<?php
namespace Trymsunsoan\Bai2\Controller\Index;
use \Magento\Framework\App\Action\Context;
use \Trymsunsoan\Bai2\Model\BannerFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    protected $bannerFactory;

    public function __construct(Context $context, BannerFactory $bannerFactory)
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    public function execute()
    {
/*      $banner = $this->bannerFactory->create();
        $data = $banner->load(1)->getData();
        print_r(json_encode( $data));*/

        //  SU DUNG COLLECTION
        //create banner instance
        $banner = $this->bannerFactory->create();
        $collection = $banner->getCollection();
        //  SELECT * FROM banner;
        //$data = $collection->getData();

        //  SELECT * FROM banner WHERE id > 20
        //$data  = $collection->addFieldToFilter('id', [ 'gt'=> 20 ])->getData();

        //  SELECT id FROM banner WHERE id > 50
        //  $data = $collection->addFieldToSelect('id')->addFieldToFilter('id', ['gt' => 50])->getData();


        //  SELECT id FROM banner WHERE id > 50 AND image LIKE '%.png';
        /*
            $data = $collection->addFieldToSelect('id')
                ->addFieldToFilter('id', ['gt' => 50])
                ->addFieldToFilter('image', ['like' => '%.png'])
                ->getData();
        */

        // thay getData() bằng getSeclect, $data lúc này chính là câu lệnh query mà Mageto  sinh ra để truy vấn vào databse
        /*
        $data = $collection->addFieldToSelect('id')
            ->addFieldToFilter('id', ['gt' => 50])
            ->addFieldToFilter('image', ['like' => '%.png'])
            ->getSelect();
        */


       //SELECT id FROM banner WHERE id > 50 AND (image LIKE '%.png' OR image LIKE '%.jpg'  )
        $data = $collection->addFieldToSelect('id')
                ->addFieldToFilter('id', ['gt' => 50])
                ->addFieldToFilter('image', [
                    ['like' => '%.png'],
                    ['like' => '%.jpg']
                ])
                ->getData();

        print_r(  json_encode( $data ));
    }
}