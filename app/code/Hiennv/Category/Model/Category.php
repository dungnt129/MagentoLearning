<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hiennv\Category\Model;

class Category extends \Magento\Catalog\Model\Category
{
    const KEY_BACKGORUND_COLOR = 'color_bg';
    /**
     * Get image url by attribute code.
     *
     * @param string $attributeCode
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getcIonCategory($attributeCode = 'icon_category')
    {
        $url = false;
        $image = $this->getData($attributeCode);
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }

        return $url;
    }

    public function getImageThumb($attributeCode = 'image_thumb')
    {
        $url = false;
        $image = $this->getData($attributeCode);
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }

        return $url;
    }

    /*
     * Get backgound color
     *
     * @Auth:Hiennv6244
     * Created : 28/08/2017
     */
    public function getBackgroundColor() {
        return $this->_getData(self::KEY_BACKGORUND_COLOR);
    }

    public function getTestNew() {
        return $this->_getData('test_new');
    }
//    public function getImageThumb() {
//        return $this->_getData('image_thumb');
//    }
}
