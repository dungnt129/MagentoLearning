<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Customer\Controller\Account;

use Cowell\Customer\Helper\Sso;

class Login extends \Magento\Customer\Controller\Account\Login
{
    protected $_responseFactory;

    protected $scopeConfig;

    protected $sso;

    const XML_PATH_CUSTOMER = 'customer_new/';

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Sso $sso
    ) {
        parent::__construct($context, $customerSession, $resultPageFactory);
        $this->scopeConfig = $scopeConfig;
        $this->_responseFactory = $responseFactory;
        $this->sso = $sso;
    }

    /**
     * Customer login form page
     *
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $sso = $this->session->getSso();
        if (empty($sso['nmid'])) {
            $url = $this->sso->checkSso();
            $this->_responseFactory->create()->setRedirect($url)->sendResponse();
            exit();
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('/');
            return $resultRedirect;
        }
    }
}
