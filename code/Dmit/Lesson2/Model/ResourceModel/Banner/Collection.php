<?php
/**
 * Created by PhpStorm.
 * User: DuongHT
 * Date: 2017-08-08
 * Time: 2:28 CH
 */

namespace Dmit\Lesson2\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected function _construct()
    {
        $this->_init('Dmit\Lesson2\Model\Banner', 'Dmit\Lesson2\Model\ResourceModel\Banner');
    }
}