<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Customer\Helper;


use Magento\Customer\Api\CustomerMetadataInterface;
use Cowell\Customer\Helper\Utility;
use Cowell\Customer\Helper\Curl;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\ManagerInterface;

/**
 * Customer helper for view.
 */
class Sso extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    protected $_storeManager;

    protected $session;

    private $customerFactory;

    private $customerRepository;

    private $eventManager;

    const SSO_STATUS_ANON = 'anon';
    const SSO_STATUS_DEEP = 'deep';
    const SSO_STATUS_INVALID = 'invalid';
    const SSO_STATUS_CHANGE = 'ssn_chg';
    const SSO_STATUS_LOGOUT = 'logout';
    public $csid;
    public $csky;
    protected $scopeConfig;
    protected $utility;
    protected $curl;
    protected $_responseFactory;
    const XML_PATH_CUSTOMER = 'customer_new/';

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param CustomerMetadataInterface $customerMetadataService
     */
    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $_storeManager,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        CustomerRepositoryInterface $customerRepository,
        ManagerInterface $eventManager,
        Utility $utility,
        Curl $curl,
        Session $customerSession
    ) {
        $this->customerFactory = $customerFactory;
        $this->eventManager = $eventManager;
        $this->customerRepository = $customerRepository;
        $this->scopeConfig = $scopeConfig;
        $this->utility = $utility;
        $this->curl = $curl;
        $this->_customerSession = $customerSession;
        $this->_storeManager = $_storeManager;
        $this->_responseFactory = $responseFactory;
        $this->session = $customerSession;
        parent::__construct($context);
        $this->csid = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER . 'token/csid_mobile', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $this->csky = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER . 'token/csky_mobile', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($this->utility->detectMobile()) {
            $this->csid = $this->scopeConfig->getValue(
                self::XML_PATH_CUSTOMER . 'token/csid_pc', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
            $this->csky = $this->scopeConfig->getValue(
                self::XML_PATH_CUSTOMER . 'token/csky_pc', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
    }

    /*
     * check sso
     *
     * Auth : Cowell6244
     * @Created : 24/08/2016
     */
    public function checkSso()
    {
        $session = $this->_customerSession;
        $sso = (!empty($session->getSso())) ? $session->getSso() : NULL;
        $url = '';
        $sso['url_callback'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK) . 'customer/account/login/';
        if (empty($sso['vtk'])) {
            //call handover
            $sso['nonce'] = $this->makeRandom(11);
            $session->setSso($sso);
            //redirect to handover auth page
            $handoverUrl = $this->scopeConfig->getValue(
                    self::XML_PATH_CUSTOMER . 'sso_link/handover_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                ) . "?" . http_build_query(['csid' => $this->csid, 'nonce' => $sso['nonce']]);
            $url = $handoverUrl;
        } else {
            //call api check vtk
            $reponseStatus = $this->ssoStatus($sso['vtk']);
            if (!$reponseStatus) {
                $this->_responseFactory->create()->setRedirect('/*/*/no-route')->sendResponse();
                exit();
            }

            switch ($reponseStatus->status) {
                case Sso::SSO_STATUS_ANON:
                    $loginUrl = $this->scopeConfig->getValue(
                            self::XML_PATH_CUSTOMER . 'sso_link/login_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                        ) . "?" . http_build_query(['csid' => $this->csid, 'next' => $sso['url_callback']]);
                    $url = $loginUrl;
                    break;
                case Sso::SSO_STATUS_DEEP:
                    $sso['nmid'] = $reponseStatus->nmid;
                    $session->setSso($sso);
                    $url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);
                    //set data customer
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $model = $objectManager->create('Cowell\Customer\Model\CustomerEntity');
                    $customer = $model->getCustomer($sso['nmid']);
                    //redirect error if not found nmid
                    if (empty($customer)) {
                        $url = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK) . 'no-route';
                    } else {
                        $customer = $this->authenticate($customer[0]['email']);
                        $this->session->setCustomerDataAsLoggedIn($customer);
                        $this->session->regenerateId();
                    }
                    break;
                case Sso::SSO_STATUS_INVALID:

                case Sso::SSO_STATUS_CHANGE:

                case Sso::SSO_STATUS_LOGOUT:
                    $url = $sso['url_callback'];
                    $session->unsSso();
                    break;
                default:
            }
        }

        return $url;
    }

    /*
     * make a ramdom string
     * @Date 23/08/2017
     */
    public static function makeRandom($length = 6)
    {
        $str = "";
        srand((float) microtime() * 10000000);
        $element = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456790";
        $element_array = preg_split("//", $element, 0, PREG_SPLIT_NO_EMPTY);
        for ($i=1; $i<=$length; $i++) {
            $str .= $element_array[array_rand($element_array, 1)];
        }
        return $str;
    }

    /*
     * Api check token sso
     * @Date 23/08/2017
     */

    public function ssoToken($htk)
    {
        $tokenUrl = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER . 'sso_link/token_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $curl = $this->curl;
        $response = $curl->post(
            $tokenUrl,
            [   'htk' => $htk,
                'csid' => $this->csid,
                'csky' => $this->csky
            ]
        );

        if ($curl->error()) {
            return false;
        }
        // 問い合わせ結果からvtkを得る
        $jsonData = json_decode($response->body);

        if (!is_object($jsonData) || !$jsonData->status || empty($jsonData->vtk)) {
            return false;
        }

        return ["vtk" => $jsonData->vtk];
    }


    public function ssoStatus($vtk)
    {
        $statusUrl = $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER . 'sso_link/status_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $curl = $this->curl;
        $response = $curl->post(
            $statusUrl, [
                'vtk' => $vtk,
                'csid' => $this->csid,
                'csky' => $this->csky]);
        if ($curl->error()) {
            return false;
        }
        // 問い合わせ結果から現在のステータスを得る
        $jsonData = json_decode($response->body);
        if (!is_object($jsonData) || !$jsonData->status) {
            return false;
        }

        return $jsonData;
    }

    /*
     * set infomation customer
     *
     * @Date : 25/08/2016
     */
    public function authenticate($username){
        $customer = $this->customerRepository->get($username);
        $this->eventManager->dispatch('customer_data_object_login', ['customer' => $customer]);
        return $customer;
    }

}
