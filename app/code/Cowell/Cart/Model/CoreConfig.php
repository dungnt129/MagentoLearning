<?php

namespace Cowell\Cart\Model;

class CoreConfig extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Cowell\Cart\Model\ResourceModel\CoreConfig');
    }
}