<?php
/**
 * Created by PhpStorm.
 * User: DuongHT
 * Date: 2017-08-08
 * Time: 2:21 CH
 */

namespace Dmit\Lesson2\Model;

class Banner extends \Magento\Framework\Model\AbstractModel {

    protected function _construct()
    {
        $this->_init('Dmit\Lesson2\Model\ResourceModel\Banner');
    }
}