<?php


namespace Cowll\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Cowll\Banner\Model\Banner',
            'Cowll\Banner\Model\ResourceModel\Banner'
        );
    }
}
