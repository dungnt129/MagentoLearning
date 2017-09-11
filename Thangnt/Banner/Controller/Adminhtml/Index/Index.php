<?php

namespace Thangnt\Banner\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Thangnt_Banner::banner_manager';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
//        $banner = $this->_objectManager->create('Thangnt\Banner\Model\ResourceModel\Banner');
//        $banner->addData([
//            'link' => 'testthoi.com',
//            'image' => 'test.png',
//            'sort_order' => 1,
//            'status' => true
//
//        ])->save();

        // Load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
//        $resultPage->setActiveMenu('Thangnt_Banner::banner_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner manager'));
        return $resultPage;
    }

}