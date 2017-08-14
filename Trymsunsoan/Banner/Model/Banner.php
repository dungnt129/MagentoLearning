<?php

namespace Trymsunsoan\Banner\Model;
class Banner extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Trymsunsoan\Banner\Model\ResourceModel\Banner');
    }
}