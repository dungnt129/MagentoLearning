<?php
namespace Trymsunsoan\Banner\Controller\Adminhtml\Index;
use Trymsunsoan\Banner\Model\BannerFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\App\Action\Context;

class InlineEdit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Trymsunsoan_Banner::save';
    protected $jsonFactory;
    protected $bannerFactory;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        BannerFactory $bannerFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $message = [];

        //getdata
        $postItems = $this->getRequest()->getParam(  'items', []);

        //Debug vi du lieu tra ve dang json ta phai dung developtool tren brower vao phan network de kiem tra
//        var_dump($postItems);die;
        foreach ( array_keys( $postItems ) as $bannerId ){
            try{
                $banner = $this->bannerFactory->create();
                $banner->load($bannerId);
                $banner->setData( $postItems[ (string) $bannerId ] );
                $banner->save();
            }catch (\Exception $e){
                $message[] = _( 'Something went wrong' );
                $error = true;
            }
        }

        return $resultJson->setData([
            'message' => $message,
            'error' => $error
        ]);
    }
}