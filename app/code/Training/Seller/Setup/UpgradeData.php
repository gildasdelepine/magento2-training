<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Config as EavConfig;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavConfig
     */
    private $eavConfig;
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * UpgradeData constructor.
     * @param EavConfig $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        EavConfig $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        EavSetupFactory $eavSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->eavConfig = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository = $attributeRepository;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $this->addCustomerAttribute($setup);
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $this->addProductAttribute($setup);
        }
    }

    /**
     * Method to add Customer interface
     *
     * @param ModuleDataSetupInterface $setup
     */
    private function addCustomerAttribute(ModuleDataSetupInterface $setup)
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'training_seller_id',
            [
                'label'    => 'Training Seller',
                'type'     => 'int',
                'input'    => 'select',
                'source'   => \Training\Seller\Option\Seller::class,
                'required' => false,
                'system'   => false,
                'position' => 900,
            ]
        );

        $this->eavConfig->clear();

        $attribute = $this->attributeRepository->get(Customer::ENTITY, 'training_seller_id');
        $attribute->setData('used_in_forms', ['adminhtml_customer']);

        // Using the repository to save the attribute prevents the "used_in_forms" field to be saved...
        $attribute->getResource()->save($attribute);

        $this->eavConfig->clear();
    }

    /**
     * Add the attribute "training_seller_id" on the product model
     *
     * @param ModuleDataSetupInterface $setup
     */
    protected function addProductAttribute(ModuleDataSetupInterface $setup)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'training_seller_ids',
            [
                'label'                    => 'Training Sellers',
                'type'                     => 'text',
                'input'                    => 'multiselect',
                'backend'                  => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class,
                'frontend'                 => '',
                'class'                    => '',
                'source'                   => \Training\Seller\Option\Seller::class,
                'global'                   => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible'                  => true,
                'required'                 => false,
                'user_defined'             => true,
                'default'                  => '',
                'searchable'               => false,
                'filterable'               => false,
                'comparable'               => true,
                'visible_on_front'         => true,
                'used_in_product_listing'  => false,
                'is_html_allowed_on_front' => true,
                'unique'                   => false,
                'apply_to'                 => 'simple,configurable'
            ]
        );

        $eavSetup->addAttributeGroup(
            Product::ENTITY,
            'bag',
            'Training'
        );

        $eavSetup->addAttributeToGroup(
            Product::ENTITY,
            'bag',
            'Training',
            'training_seller_ids'
        );

        $this->eavConfig->clear();
    }
}