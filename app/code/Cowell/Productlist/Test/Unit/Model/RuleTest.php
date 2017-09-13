<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Productlist\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class RuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Cowell\Productlist\Model\Rule
     */
    protected $rule;

    /**
     * @var \Cowell\Productlist\Model\Rule\Condition\CombineFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $combineFactory;

    protected function setUp()
    {
        $this->combineFactory = $this->getMockBuilder('Cowell\Productlist\Model\Rule\Condition\CombineFactory')
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $objectManagerHelper = new ObjectManagerHelper($this);

        $this->prepareObjectManager([
            [
                'Magento\Framework\Api\ExtensionAttributesFactory',
                $this->getMock('Magento\Framework\Api\ExtensionAttributesFactory', [], [], '', false)
            ],
            [
                'Magento\Framework\Api\AttributeValueFactory',
                $this->getMock('Magento\Framework\Api\AttributeValueFactory', [], [], '', false)
            ],
        ]);

        $this->rule = $objectManagerHelper->getObject(
            'Cowell\Productlist\Model\Rule',
            [
                'conditionsFactory' => $this->combineFactory
            ]
        );
    }

    public function testGetConditionsInstance()
    {
        $condition = $this->getMockBuilder('Cowell\Productlist\Model\Rule\Condition\Combine')
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();
        $this->combineFactory->expects($this->once())->method('create')->will($this->returnValue($condition));
        $this->assertSame($condition, $this->rule->getConditionsInstance());
    }

    public function testGetActionsInstance()
    {
        $this->assertNull($this->rule->getActionsInstance());
    }

    /**
     * @param $map
     */
    private function prepareObjectManager($map)
    {
        $objectManagerMock = $this->getMock('Magento\Framework\ObjectManagerInterface');
        $objectManagerMock->expects($this->any())->method('getInstance')->willReturnSelf();
        $objectManagerMock->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));
        $reflectionClass = new \ReflectionClass('Magento\Framework\App\ObjectManager');
        $reflectionProperty = $reflectionClass->getProperty('_instance');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($objectManagerMock);
    }
}
