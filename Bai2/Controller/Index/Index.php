<?php

namespace Robin\Bai2\Controller\Index;

use \Magento\Framework\App\Action\Context;
use \Robin\Bai2\Model\BannerFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $bannerFactory;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Robin\Bai2\Model\BannerFactory $bannerFactory)
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //create banner instance
        $banner = $this->bannerFactory->create();
        $collection = $banner->getCollection();

        //SELECT * FROM banner
        //$data = $collection->getData();

        //SELECT * FROM banner WHERE id > 50
        //$data = $collection->addFieldToFilter('id', ['gt' => 50])->getData();

        //SELECT id FROM banner WHERE id > 70
//        $data = $collection->addFieldToSelect('id')
//            ->addFieldToFilter('id', ['gt' => 70])
//            ->getData();

        //SELECT id FROM banner WHERE id > 70  AND image LIKE '%.png'
        $query = $collection->addFieldToSelect('id')
            ->addFieldToFilter('id', ['gt' => 70])
            ->addFieldToFilter('image', ['like' => '%.png'])
            ->getSelect();

        echo $query;
//        print_r(json_encode($data));
    }
}
