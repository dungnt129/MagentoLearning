<?php

namespace Cowll\EShopper\Block;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/21/2017
 * Time: 9:56 AM
 */
use Magento\Framework\View\Element\Template;
class HeaderTop extends Template
{
    protected function _beforeToHtml()
    {
        $config = $this->_scopeConfig;
        $phone = $config->getValue('general/store_information/phone');
        $email = $config->getValue('trans_email/ident_general/email');
        $facebook = $config->getValue('social/social_config/facebook',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $twitter = $config->getValue('social/social_config/twitter');
        $linkedin = $config->getValue('social/social_config/linkedin');

        $this->setData('store_phone', $this->escapeHtml($phone));
        $this->setData('store_email', $this->escapeHtml($email));
        $this->setData('store_facebook', $this->escapeHtml($facebook));
        $this->setData('store_twitter', $this->escapeHtml($twitter));
        $this->setData('store_linkedin', $this->escapeHtml($linkedin));
    }
}