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

    public function __construct(
        Template\Context $context,
        \Dmit\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,

        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;

        $this->setTemplate('widget.phtml');
        parent::__construct(
            $context,
            $data
        );
    }

//    protected function _toHtml()
//    {
//        $this->setTemplate($this->getData('slide'));
//    }


    protected function getPageSize()
    {
        return $this->hasData('banner_count') ? $this->getData('banner_count') : self::IMAGE_LIMIT;
    }

    protected function _beforeToHtml()
    {
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

}
