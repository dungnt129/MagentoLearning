<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomUpdateCartObserver implements ObserverInterface
{
    /**
     * @var \Cowell\Cart\Helper\CustomChangeQtyProduct
     */
    protected $changeQtyProductHelper;

    /**
     * @param \Cowell\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper
     */
    public function __construct(
        \Cowell\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper
    ) {
        $this->changeQtyProductHelper = $changeQtyProductHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * Auth: Hiennv6244
     * Created : 20-09-2017
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $items = $observer->getEvent()->getQuoteItem();
        $this->changeQtyProductHelper->updateQtyProduct($items, true);
    }
}
