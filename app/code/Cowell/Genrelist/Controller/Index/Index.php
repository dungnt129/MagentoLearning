<?php

namespace Cowell\Genrelist\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action {

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $_urlInterface;

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
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_urlInterface = $urlInterface;
        parent::__construct($context);
    }

    public function getUrlInterfaceData()
    {
        return $this->_urlInterface->getUrl();
    }

    /**
     * Loads page content
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setHeader('Genrelist', 'true');
        return $resultPage;
    }

}
