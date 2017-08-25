<?php
/**
 * Created by PhpStorm.
 * User: DuongHT
 * Date: 2017-08-08
 * Time: 2:28 CH
 */

namespace Dmit\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Dmit\Banner\Model\Banner', 'Dmit\Banner\Model\ResourceModel\Banner');
    }

    protected function filterOrder($payment_method)
    {

        $this->sales_order_table = "main_table";
        $this->sales_order_payment_table = $this->getTable("banner_category");
        $this->getSelect()
            ->join(array('payment' => $this->sales_order_payment_table), $this->sales_order_table . '.entity_id= payment.parent_id',
                array('payment_method' => 'payment.method',

                    'order_id' => $this->sales_order_table.'.entity_id'
                )
            );

        $this->getSelect()->where("payment_method=".$payment_method);
    }
}