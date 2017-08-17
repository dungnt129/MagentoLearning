<?php

namespace Trymsunsoan\Banner\Model\ResourceModel;
class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        //        tablename, primary key
        $this->_init('banner', 'id');
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData( 'image' );
        if( $image != null ){
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get( 'Trymsunsoan\Banner\BannerImageUpload' );
            $imageUploader->moveFileFromTmp( $image );
            return $this;
        }
    }
}


