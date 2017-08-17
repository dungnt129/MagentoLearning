<?php

namespace Robin\Bai1\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action {

    public function execute()
    {
        $extension = ['.png', '.jpg', '.gif'];
          $url = ['https://www.google.com.vn/', 'http://www.w3schools.com/', 'https://techmaster.vn/'];

            for ($i = 1; $i <= 100; $i++) {
                $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
                // Insert data
                $banner->addData([
                    'link' => $url[rand(0, 2)],
                    'image' => 'image' . $i . $extension[rand(0, 2)],
                    'sort_order' => $i,
                    'status' => rand(0, 1)
                ])->save();
            }
        /**
         * Select, update, delete
         */
            // Select record with id = 1
            $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
            $data = $banner->load(1)->getData();
          print_r(json_encode($data));

        // Update selected record
        $data->setImage('logo.png')->setLink('google.com')->save();

        // Delete selected record
        $data->delete();
        echo "<br/>Done.";
        exit;
    }

}