<?php

namespace Cowell\Cart\Model\ResourceModel\Item;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'item_id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Cowell\Cart\Model\QuoteItem', 'Cowell\Cart\Model\ResourceModel\Item');
    }

}