<?php
namespace Trymsunsoan\Banner\Controller\Index;
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
        echo "Banner";
        exit;
    }
}