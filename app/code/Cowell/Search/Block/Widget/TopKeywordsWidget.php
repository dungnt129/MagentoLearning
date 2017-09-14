<?php

namespace Cowell\Search\Block\Widget;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Search\Model\ResourceModel\Query\CollectionFactory;

class TopKeywordsWidget extends Template implements BlockInterface
{
    const DEFAULT_KEYWORDS_COUNT = 5;
    protected $_collection;
    protected $_template = 'widget/top_keywords.phtml';
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Module\Manager $moduleManager,
        CollectionFactory $queriesFactory,
        array $data = []
    )
    {
        $this->_moduleManager = $moduleManager;
        $this->_queriesFactory = $queriesFactory;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function getKeywordsCount()
    {
        if( !$this->hasData('keywords_count') ){
            return self::DEFAULT_KEYWORDS_COUNT;
        }
        return $this->getData('keywords_count');
    }

    protected function _prepareCollection()
    {
        $this->_collection = $this->_queriesFactory->create();

        if ($this->getRequest()->getParam('store')) {
            $storeIds = $this->getRequest()->getParam('store');
        } elseif ($this->getRequest()->getParam('website')) {
            $storeIds = $this->_storeManager->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
        } elseif ($this->getRequest()->getParam('group')) {
            $storeIds = $this->_storeManager->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
        } else {
            $storeIds = '';
        }

        $this->_collection->setPopularQueryFilter($storeIds);
//        echo $this-> getKeywordsCount();
//        die();
        return $this->_collection->addFieldToSelect('query_text')->setPageSize( $this->getKeywordsCount() )->setCurPage(1)->getData();
    }

    protected function _beforeToHtml()
    {
        try {
            $keywords = $this->_prepareCollection();
            $this->setData('keywords', $keywords);
            return parent::_beforeToHtml(); // TODO: Change the autogenerated stub
        } catch (\Exception $e) {
            echo "Error while get top keywords - view module Cowell\Aeon\Block\TopKeywords\TopKeywordsWidget.php";
        }
    }
}
