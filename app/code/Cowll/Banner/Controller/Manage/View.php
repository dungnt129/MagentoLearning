<?php


namespace Cowll\Banner\Controller\Manage;

class View extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $banners = $this->_objectManager->create('Cowll\Banner\Model\Banners');
        $data = $banners->load(1)->getData();
        print_r(json_encode($data));
        die('---- done ------');
//        return $this->resultPageFactory->create();
    }
}
