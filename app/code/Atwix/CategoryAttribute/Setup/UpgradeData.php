<?php


namespace Atwix\CategoryAttribute\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '9.0.1', '<')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'image_thumb', [
                    'type'      	=> 'varchar',
                    'label'      	=> 'Image - Thumb',
                    'input'     	=> 'image',
                    'required' 	=> false,
                    'sort_order'  => 6,
                    'backend'	=> 'Atwix\CategoryAttribute\Model\Category\Attribute\Backend\Thumb',
                    'global'    	=> \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'group'    	=> 'General Information',
                ]
            );
        }

        $setup->endSetup();
    }
}