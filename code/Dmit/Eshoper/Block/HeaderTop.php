<?php

namespace Dmit\Eshoper\Block;

class HeaderTop extends \Magento\Framework\View\Element\Template {

    protected function _beforeToHtml()
    {
        $config = $this->_scopeConfig;
        // Key = tab + group id + input
        $phone = $config->getValue('general/store_information/phone');
        $email = $config->getValue('trans_email/inden_general/email');
        $this->setData('store_phone', $phone);
        $this->setData('store_email', $email);
    }
}


