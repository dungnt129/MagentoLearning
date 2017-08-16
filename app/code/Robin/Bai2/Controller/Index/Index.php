<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 11:23 AM
 */


namespace Robin\Bai2\Controller\Index;


use Magento\Framework\App\Action\Context;
use Robin\Bai2\Model\BannerFactory;

class Index extends \Magento\Framework\App\Action\Action {


    protected $bannerFactory;

    public function __construct(Context $context, BannerFactory $bannerFactory)
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }


    /**
     *
     */
    public function execute()
    {
        // TODO: Implement execute() method.

//        /**
//         * Insert data into table
//         */
//        $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
//        $banner->addData([
//            'link' => 'banner link',
//            'image' =>  'avatar.png',
//            'sort_order' => 1,
//            'status' => true
//
//        ])->save();
//
//        // get data
//        $data = $banner->load(1);
//        print_r(json_encode($data->getData()));
//
//        /**
//         * Update data
//         */
//
//        $data->setImage("logo.png")->save();
//
//        /**
//         * Delete data
//         */
//        $data->delete();
//
//        echo "Done";

        /**
         * Learning Collection
         */

        $banner = $this->bannerFactory->create();
        $collection = $banner->getCollection();

        // Select * from banner
//        $data = $collection
//                ->addFieldToSelect('id')
//                ->addFieldToSelect('image')
//                ->addFieldToFilter('id', ['gt' => 3])
//                ->addFieldToFilter('image', ['like' => '%.png'])
//            ->getData();

        //print_r(json_encode($data));

        // check query string
        $query = $collection
            ->addFieldToSelect('id')
            ->addFieldToSelect('image')
            ->addFieldToFilter('id', ['gt' => 3])
            ->addFieldToFilter('image', ['like' => '%.png'])
            ->getSelect();

        echo ' Query:  ' . $query;

    }
}