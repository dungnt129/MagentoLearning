<?php

namespace Cowell\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Cowell\Banner\Model\Banner', 'Cowell\Banner\Model\ResourceModel\Banner');
    }

}