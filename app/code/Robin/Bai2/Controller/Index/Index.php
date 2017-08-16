<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 11:23 AM
 */


namespace Robin\Bai2\Controller\Index;


class Index extends \Magento\Framework\App\Action\Action {


    public function execute()
    {
        // TODO: Implement execute() method.

        /**
         * Insert data into table
         */
        $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
//        $banner->addData([
//            'link' => 'banner link',
//            'image' =>  'avatar.png',
//            'sort_order' => 1,
//            'status' => true
//
//        ])->save();

        // get data
        $data = $banner->load(1);
        print_r($data->getData());

        /**
         * Update data
         */

//        $data->setImage("logo.png")->save();

        /**
         * Delete data
         */
        $data->delete();

        echo "Done";

    }
}