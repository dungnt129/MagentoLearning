<?php

namespace Robin\Bai3\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Robin\Bai3\Model\Banner', 'Robin\Bai3\Model\ResourceModel\Banner');
    }

}