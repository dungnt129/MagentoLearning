<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Robin\Bai2\Block\Banner;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Catalog Products List widget block
 * Class ProductsList
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BannerWidget extends Template implements BlockInterface
{

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder
     * @param \Magento\CatalogWidget\Model\Rule $rule
     * @param \Magento\Widget\Helper\Conditions $conditionsHelper
     * @param array $data
     */

    protected $dulieu;

    public function __construct(
        Template\Context $context,
        \Robin\Bai2\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * {@inheritdoc}
     */

    protected function _beforeToHtml()
    {
        $collection = $this->bannerCollectionFactory->create();
        $dulieu = $collection->addFilter('status',['eq' => true])->getData();
        $this->setData('banners',$dulieu);
        $this->setData('mediaUrl',$this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).'banner/images/');


        $slider_style =$this->getData('slide');
        if($slider_style == 1) {
            $this->setTemplate('widget.phtml');
        }else
        {
            $this->setTemplate('widget2.phtml');
        }
        return parent::_beforeToHtml();
    }

    /**
     * Prepare and return product collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */

}
