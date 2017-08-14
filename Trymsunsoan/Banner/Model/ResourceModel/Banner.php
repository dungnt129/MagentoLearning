<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 8/11/2017
 * Time: 5:31 PM
 */
namespace Trymsunsoan\Banner\Model\ResourceModel;
class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        //        tablename, primary key
        $this->_init('banner', 'id');
    }
}