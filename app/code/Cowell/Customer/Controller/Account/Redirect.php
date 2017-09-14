<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Customer\Controller\Account;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Cowell\Customer\Helper\Sso;

class Redirect extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    protected $sso;

    protected $_responseFactory;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $resultPageFactory,
        Sso $sso,
        \Magento\Framework\App\ResponseFactory $responseFactory
    ) {
        parent::__construct($context);
        $this->session = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
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
        //check htk
        if (!empty($this->getRequest()->getParam('htk')) && isset($sso['nonce']) && $sso['nonce'] == $this->getRequest()->getParam('nonce')) {
            //call api check token
            $reponseToken = $this->sso->ssoToken($this->getRequest()->getParam('htk'));
            if (!$reponseToken) {
                $this->_responseFactory->create()->setRedirect('/*/*/no-route')->sendResponse();
                exit();
            }
            $sso['htk'] = $this->getRequest()->getParam('htk');
            $sso['vtk'] = $reponseToken['vtk'];
            $this->session->setSso($sso);
            $this->_responseFactory->create()->setRedirect($sso['url_callback'])->sendResponse();
            exit();
        }

        $this->_responseFactory->create()->setRedirect('/*/*/no-route')->sendResponse();
        exit();
    }


}
