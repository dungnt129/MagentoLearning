<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Dmit\Banner\Block\Banner;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Catalog Products List widget block
 * Class ProductsList
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BannerWidget extends Template implements BlockInterface
{
    const IMAGE_LIMIT = 20;
    protected $bannerCollectionFactory;
    protected $_resource;

    public function __construct(
        Template\Context $context,
        \Dmit\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Framework\App\ResourceConnection $Resource,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->_resource = $Resource;

        parent::__construct($context, $data);
    }
    
    protected function getPageSize()
    {
        return $this->hasData('banner_count') ? $this->getData('banner_count') : self::IMAGE_LIMIT;
    }

    protected function _beforeToHtml()
    {
//        $categoryTable = $this->_resource->getTableName('banner_category');
//        $joinCollection = $this->bannerCollectionFactory->create();
//        $joinCollection
//            ->getSelect()
//            ->join(
//                ['cat' => $categoryTable],
//                "main_table.cat_id = cat.id",
//                [
//                    'category_id' => 'cat.id',
//                    'category_name' => 'cat.name',
//                    'banner_id'   => 'main_table.id',
//                    'banner_image' => 'main_table.image',
//                    'banner_link' => 'main_table.link'
//                ]
//            )
//            ->where("main_table.status = 1");
//
//        echo($joinCollection->getSelect());
//        die;

        // Init collecttion
        $collection = $this->bannerCollectionFactory->create();
        // Get data
        $banners = $collection->addFieldToFilter('status', ['eg' => true])
            ->setPageSize($this->getPageSize())
            ->getData();
        $this->setData('banners', $banners);
        $this->setData('mediaURL', $this->_storeManager
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'banner/images/');
        
        return parent::_beforeToHtml();
    }

    /*protected function _prepareLayout()
    {
        $text = $this->getJoinData();
        $this->setText($text);
    }

    public function getJoinData(){
        $collection = $this->bannerCollectionFactory->create()->getCollection();
        $second_table_name = $this->_resource->getTableName('banner_category');

        $collection->getSelect()->joinLeft(array('second' => $second_table_name),
            'main_table.cat_id = second.id');
        echo $collection->getSelect()->__toString();
        exit();

    }*/

}
