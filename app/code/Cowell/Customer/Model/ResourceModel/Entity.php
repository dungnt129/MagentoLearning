<?php

namespace Cowell\Customer\Model\ResourceModel;

class Entity extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('customer_entity', 'entity_id');
    }
}