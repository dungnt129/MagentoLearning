<?php


namespace Cowll\Banner\Controller\Manage;

class Create extends \Magento\Framework\App\Action\Action
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
        $extension = ['.png', '.jpg', '.gif'];
        $url = ['https://www.google.com.vn/', 'http://www.w3schools.com/', 'https://techmaster.vn/'];
        for ($i = 1; $i <= 100; $i++) {
            $banners = $this->_objectManager->create('Cowll\Banner\Model\Banners');
            $banners->addData([
                'link' => $url[rand(0, 2)],
                'image' => 'image' . $i . $extension[rand(0, 2)],
                'sort_order' => $i,
                'status' => rand(0, 1)
            ])->save();
        }
        die('-----done-----');
        //return $this->resultPageFactory->create();
    }
}
