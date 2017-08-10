<?php


namespace Cowll\Banner\Model\ResourceModel;

class Banners extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('banners', 'id');
    }
}
