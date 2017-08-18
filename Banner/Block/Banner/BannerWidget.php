<?php
namespace Robin\Banner\Block\Banner;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Robin\Banner\Model\ResourceModel\Banner\CollectionFactory;

class BannerWidget extends Template implements BlockInterface
{
    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->setTemplate('widget.phtml');
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
        // Init collection
        $collection = $this->bannerCollectionFactory->create();
        // Get enabled images
        $banners = $collection->addFieldToFilter('status', ['eq' => true])->getData();
        // Set data
        $this->setData('banners', $banners);
        $this->setData('mediaURL', $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'banner/images/');
        // Return to View
        return parent::_beforeToHtml();
    }
}
