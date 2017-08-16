<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 5:16 PM
 */


namespace Robin\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected  function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('Robin\Banner\Model\Banner','Robin\Banner\Model\ResourceModel\Banner');

    }
}