<?php


namespace Atwix\CategoryAttribute\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{

    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'color_bg',
            [
                'type' => 'varchar',
                'label' => 'color_bg',
                'input' => 'text',
                'sort_order' => 333,
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => 'General Information',
                'backend' => '',
                'used_in_product_listing' => true, // for category pages
                'visible_on_front' => true, // for frontend??
                'is_used_in_grid' => true, // for category pages
                'is_visible_in_grid' => true // for category pages
            ]
        );

//        $eavSetup->addAttribute(
//            \Magento\Catalog\Model\Category::ENTITY,
//            'icon_category',
//            [
//                'type' => 'varchar',
//                'label' => 'icon_category',
//                'input' => 'image',
//                'sort_order' => 333,
//                'source' => '',
//                'global' => 1,
//                'visible' => true,
//                'required' => false,
//                'user_defined' => false,
//                'group' => 'General Information',
//                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
//                'used_in_product_listing' => true, // for category pages
//                'visible_on_front' => true, // for frontend??
//                'is_used_in_grid' => true, // for category pages
//                'is_visible_in_grid' => true // for category pages
//            ]
//        );
    }
}