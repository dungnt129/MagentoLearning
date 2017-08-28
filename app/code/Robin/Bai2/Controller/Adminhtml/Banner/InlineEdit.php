<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Bai2\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Robin\Bai2\Model\BannerFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Robin_Bai2::save';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $jsonFactory;
    protected $bannerFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        \Magento\Framework\Registry $registry,
        BannerFactory $bannerFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->bannerFactory = $bannerFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
//    protected function _initAction()
//    {
//        // load layout, set active menu and breadcrumbs
//        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
//        $resultPage = $this->resultPageFactory->create();
//        $resultPage->setActiveMenu('Robin_Bai2::BannerManager');
//        return $resultPage;
//    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postData = $this->getRequest()->getParam('items',[]);

        foreach (array_keys($postData) as $bannerId)
        {
            try{
                $banner = $this->bannerFactory->create();
                $banner->load($bannerId);
                $banner->setData($postData[(string)$bannerId]);
                $banner->save();
            }catch (\Exception $e)
            {
                $messages[] = __('Wrong');
                $error = true;
            }

            return $resultJson->setData([
                'messages' => $messages,
                'error' => $error
            ]);
        }
    }
}
