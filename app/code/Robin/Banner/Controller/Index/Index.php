<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 11:23 AM
 */


namespace Robin\Banner\Controller\Index;


use Magento\Framework\App\Action\Context;
use Robin\Banner\Model\BannerFactory;

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

        $banner = $this->bannerFactory->create();
        $collection = $banner->getCollection();

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