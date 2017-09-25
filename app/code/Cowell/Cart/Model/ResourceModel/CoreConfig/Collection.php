<?php

namespace Cowell\Cart\Model\ResourceModel\CoreConfig;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Cowell\Cart\Model\CoreConfig', 'Cowell\Cart\Model\ResourceModel\CoreConfig');
    }

}