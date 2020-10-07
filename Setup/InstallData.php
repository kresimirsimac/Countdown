<?php

namespace Iweb\Countdown\Setup;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    protected $eavSetupFactory;
    
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }
    
    public function install(
        \Magento\Framework\Setup\ModuleDataSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'release_date',
            [
                // eav attribute table
                'backend'                    => \Magento\Eav\Model\Entity\Attribute\Backend\Datetime::class,
                'type'                       => 'datetime',
                'frontend'                   => \Magento\Eav\Model\Entity\Attribute\Frontend\Datetime::class,
                'input'                      => 'date',
                'label'                      => 'Release Date',
                'required'                   => false,
                'user_defined'               => true,
                
                // catalog_eav_attribute table
                'global'                     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'searchable'                 => true,
                'visible_on_front'           => true,
                'used_in_product_listing'    => true,
                'used_for_sort_by'           => true,
                'visible_in_advanced_search' => true,
                'used_for_promo_rules'       => true,
                'is_used_in_grid'            => true,
                'is_filterable_in_grid'      => true,
                
                // other
                'group'                      => 'Preorder'
            ]
        );
    }
}
