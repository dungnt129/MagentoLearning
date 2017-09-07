<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hiennv\Category\Model;

class Category extends \Magento\Catalog\Model\Category
{
    const KEY_BACKGORUND_COLOR = 'color_category';
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

    /*
     * Get backgound color
     *
     * @Auth:Hiennv6244
     * Created : 28/08/2017
     */
    public function getBackgroundColor() {
        return $this->_getData(self::KEY_BACKGORUND_COLOR);
    }
}
