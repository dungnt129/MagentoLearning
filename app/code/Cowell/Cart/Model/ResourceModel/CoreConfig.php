<?php

namespace Cowell\Cart\Model\ResourceModel;

class CoreConfig extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('core_config_data', 'config_id');
    }
}