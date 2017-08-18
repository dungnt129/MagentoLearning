<?php

namespace Robin\Banner\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('banner', 'id');
    }

    protected  function  _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData('image');
        // Check when new image uploaded
        if ($image != null) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Robin\Banner\BannerImageUpload');
            $imageUploader->moveFileFromTmp($image);
        }

        return $this;
    }
}
