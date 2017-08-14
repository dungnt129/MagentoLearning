<?php
namespace Trymsunsoan\Banner\Model\ResourceModel\Banner;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
     protected  function _construct()
     {

         $this->_init( 'Trymsunsoan\Banner\Model\Banner', 'Trymsunsoan\Banner\Model\ResourceModel\Banner' );
     }
}