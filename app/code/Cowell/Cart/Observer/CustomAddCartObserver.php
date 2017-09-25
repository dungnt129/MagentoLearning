<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomAddCartObserver implements ObserverInterface
{
    /**
     * @var \Cowell\Cart\Helper\CustomChangeQtyProduct
     */
    protected $changeQtyProductHelper;

    protected $request;

    /**
     * @param \Cowell\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper
     */
    public function __construct(
        \Cowell\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->changeQtyProductHelper = $changeQtyProductHelper;
        $this->request = $request;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * Update qty product after add product
     *
     * Auth: Hiennv6244
     * Created : 20-09-2017
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $action  = $this->request->getActionName();
        if ($this->request->getModuleName() == 'checkout') {
            $items = $observer->getEvent()->getItems();
            $this->changeQtyProductHelper->updateQtyProduct($items, $action);
        }
    }
}
