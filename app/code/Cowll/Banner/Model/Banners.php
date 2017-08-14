<?php


namespace Cowll\Banner\Model;

class Banners extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('Cowll\Banner\Model\ResourceModel\Banner');
    }
}
