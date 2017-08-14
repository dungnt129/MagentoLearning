<?php
namespace Trymsunsoan\Bai2\Model\ResourceModel\Banner;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
     protected  function _construct()
     {

         $this->_init( 'Trymsunsoan\Bai2\Model\Banner', 'Trymsunsoan\Bai2\Model\ResourceModel\Banner' );
     }
}