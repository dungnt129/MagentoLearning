<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Productlist\Controller\Adminhtml\Product\Widget;

use Magento\Rule\Model\Condition\AbstractCondition;

/**
 * Class Conditions
 */
class Conditions extends \Cowell\Productlist\Controller\Adminhtml\Product\Widget
{
    /**
     * @var \Cowell\Productlist\Model\Rule
     */
    protected $rule;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Cowell\Productlist\Model\Rule $rule
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Cowell\Productlist\Model\Rule $rule
    ) {
        $this->rule = $rule;
        parent::__construct($context);
    }

    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $typeData = explode('|', str_replace('-', '/', $this->getRequest()->getParam('type')));
        $className = $typeData[0];

        $model = $this->_objectManager->create($className)
            ->setId($id)
            ->setType($className)
            ->setRule($this->rule)
            ->setPrefix('conditions');

        if (!empty($typeData[1])) {
            $model->setAttribute($typeData[1]);
        }

        $result = '';
        if ($model instanceof AbstractCondition) {
            $model->setJsFormObject($this->getRequest()->getParam('form'));
            $result = $model->asHtmlRecursive();
        }
        $this->getResponse()->setBody($result);
    }
}
