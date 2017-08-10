<?php

namespace Cowll\Banner\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $bannersFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Cowll\Banner\Model\BannersFactory $bannersFactory
    ) {
        $this->bannersFactory = $bannersFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $banner = $this->bannersFactory->create();
        $collection = $banner->getCollection();
        $data = $collection
                    ->addFilter('id >', 50)
                    ->getData();
        var_dump($data);
        die("---------------------");
        return $this->bannersFactory->create();
    }
}
