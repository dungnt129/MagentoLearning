<?php

namespace Robin\Banner\Controller\Index;

use \Magento\Framework\App\Action\Context;
use \Robin\Banner\Model\BannerFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $bannerFactory;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Robin\Banner\Model\BannerFactory $bannerFactory)
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        echo "Hello";
    }
}
