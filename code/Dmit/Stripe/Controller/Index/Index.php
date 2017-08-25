<?php

namespace Dmit\Stripe\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action {


//    protected $_joinFactory;

//    public function __construct(\Magento\Framework\App\Action\Context $context, Dmit\Stripe\Model\ResourceModel\JoinModel\CollectionFactory $_joinFactory)
//    {
//        $this->_joinFactory = $_joinFactory;
//        parent::__construct($context);
//    }
    public function execute()
    {
        
        /**
         * $orderTable name of order table
         */
        $orderTable = $this->_resource->getTableName('sales_order');

        /**
         * $customerTable name of customer table
         */
        $customerTable = $this->_resource->getTableName('customer_entity');

        $joinCollection = $this->_joinFactory->create();
        $joinCollection
            ->join(
                ['ot'=>$orderTable],
                "main_table.order_id = ot.entity_id"
            );

        echo $joinCollection->getSelect();die;

        // Init collection
        $collection = $this->bannerFactory->create()->getCollection();
        // SELECT * FROM banner
        $data = $collection->getData();
        print_r(json_encode($data));
        // SELECT * FROM banner WHERE id > 50
//        $data = $collection->addFieldToFilter('id', ['gt' => 50])->getData();
        // SELECT id FROM banner WHERE id > 50
//        $data = $collection->addFieldToSelect('id')
//            ->addFieldToFilter('id', ['gt' => 50])->getData();
        // SELECT * FROM banner WHERE image LIKE '%.png'
//        $data = $collection->addFieldToFilter('image', ['like' => '%.png'])->getData();
//        print_r(json_encode($data));
        // SELECT * FROM banner WHERE image LIKE '%.png' AND id > 50
//        $query = $collection->addFieldToFilter('image', ['like' => '%.png'])
//            ->addFieldToFilter('id', ['gt' => 50])
//            ->getSelect();
        // SELECT * FROM banner WHERE (image LIKE '%.png' OR image LIKE '%.jpg') AND id > 50
//        $query = $collection->addFieldToFilter('id', ['gt' => 50])
//            ->addFieldToFilter('image', [
//                ['like' => '%.png'],
//                ['like' => '%.jpg']
//            ])->getSelect();
        // SELECT * FROM banner WHERE id > 50 OR image LIKE '%.jpg'
//        $query = $collection->addFieldToFilter(['id', 'image'], [
//            ['gt' => 50],
//            ['like' => '%.png']
//        ])->getSelect();
//        echo $query;
        echo "<br/>Done.";
        exit;
    }

}