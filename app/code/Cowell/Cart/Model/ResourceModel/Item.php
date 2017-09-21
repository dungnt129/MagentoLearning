<?php

namespace Cowell\Cart\Model\ResourceModel;

class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('quote_item', 'item_id');
    }
}