<?php

namespace Hiennv\Category\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action {

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Request instance
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {

        $this->resultPageFactory = $resultPageFactory;

        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Loads page content
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        $catId = (int) $this->getRequest()->getParam('id', false);
        $this->_coreRegistry->register('catid', $catId);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('All Categories'));

        return $resultPage;
    }

}
