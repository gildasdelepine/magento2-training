<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Eav\Api\AttributeRepositoryInterface;
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

    public function __construct(
        EavConfig $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->eavConfig = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository = $attributeRepository;
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
}