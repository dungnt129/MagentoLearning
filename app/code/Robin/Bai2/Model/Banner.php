<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 5:11 PM
 */

namespace Robin\Bai2\Model;

class Banner extends \Magento\Framework\Model\AbstractModel {

    protected function _construct()
    {
        $this->_init("Robin\Bai2\Model\ResourceModel\Banner");
    }
}