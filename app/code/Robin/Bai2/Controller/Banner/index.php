<?php
namespace Robin\Bai2\Controller\Banner;

use Magento\Framework\App\Action\Context;
use Robin\Bai2\Model\BannerFactory;


class index extends \Magento\Framework\App\Action\Action{


    protected  $bannerFactory;
    public function __construct(Context $context,BannerFactory $bannerFactory)
    {

        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $collection = $this->bannerFactory->create()->getCollection();
        $data = $collection->addFieldToFilter('id', ['gt' => 50])->getData();
        var_dump($data);die;

        $banner = $this->bannerFactory->create();


        //Lay 1 row
//        $rs = $banner->load(10)->getData();
//        print_r(json_encode($rs));
//        exit;

        $collecttion = $banner->getCollection();

        //Lay * db
        $rs = $collecttion->getData();

        var_dump($rs);
        exit;
        print_r(json_encode($rs));

//        Insert du lieu

//        $link_array = ['https://hiset.ets.org/rsc/img/icons/icon-tt-checklist.svg','https://i.vimeocdn.com/portrait/58832_300x300','https://www.accesshq.com/workspace/images/icons/test-your-technology.svg'];
//        for($i = 0;$i<100;$i++)
//        {
//            $image_name = 'Ảnh_'.$i;
//            $link_item = rand(0,2);
//            $link = $link_array[$link_item];
//            $status = rand(0,1);
//            $banner = $this->_objectManager->create('Robin\Bai2\Model\Banner');
//                $banner->addData([
//                    'link' => $link,
//                    'image' => $image_name,
//                    'sort_order' => $i+1,
//                    'status' => $status
//                ]);
//             $banner->save();
//        }

    }
}