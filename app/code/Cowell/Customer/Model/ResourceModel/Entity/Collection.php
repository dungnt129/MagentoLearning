<?php

namespace Cowell\Customer\Model\ResourceModel\Entity;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Cowell\Customer\Model\CustomerEntity', 'Cowell\Customer\Model\ResourceModel\Entity');
    }

}