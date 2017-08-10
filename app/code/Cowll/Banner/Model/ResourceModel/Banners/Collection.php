<?php


namespace Cowll\Banner\Model\ResourceModel\Banners;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Cowll\Banner\Model\Banners',
            'Cowll\Banner\Model\ResourceModel\Banners'
        );
    }
}
