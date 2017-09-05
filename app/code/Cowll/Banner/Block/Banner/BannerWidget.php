<?php

namespace Cowll\Banner\Block\Banner;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Cowll\Banner\Model\ResourceModel\Banner\CollectionFactory;

class BannerWidget extends Template implements BlockInterface
{

    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        CollectionFactory $bannerCollectionFactory)
    {
        $this->setTemplate('widget.phtml');
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        //dd($context->getStoreManager()->getStore()->getCode());
        parent::__construct($context, $data);
    }

    /**
     * Set data to View
     */
    protected function _beforeToHtml()
    {
        $collection = $this->bannerCollectionFactory->create();
        $limit = $this->getData('number_image')?(int)$this->getData('number_image'):10;
        $banners = $collection->addFieldToFilter('status', ['eq' => true])->addOrder('sort_order')->setPageSize($limit)->getData();
        $this->setData('banners', $banners);
        $this
            ->setData('mediaURL', $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'banner/images/');
        return parent::_beforeToHtml();
    }

}