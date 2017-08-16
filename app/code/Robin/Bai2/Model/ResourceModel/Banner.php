<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 5:13 PM
 */

namespace Robin\Bai2\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    protected  function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('banner', 'id');

    }
}