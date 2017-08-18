<?php

namespace Robin\Bai3\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

//    const ADMIN_RESOURCE = 'Robin_Bai3::banner_manager';
//
//    protected $resultPageFactory;
//
//    public function __construct(
//        \Magento\Backend\App\Action\Context $context,
//        \Magento\Framework\View\Result\PageFactory $resultPageFactory
//    ) {
//        parent::__construct($context);
//        $this->resultPageFactory = $resultPageFactory;
//    }

    public function execute()
    {
        echo "Stop!!";
        exit;
        // Load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Robin_Bai3::banner_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner manager'));

        return $resultPage;
    }

}