<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

/**
 * Upgrade Data
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavConfig
     */
    protected $eavConfig;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @param EavConfig                    $eavConfig
     * @param CustomerSetupFactory         $customerSetupFactory
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        EavConfig                    $eavConfig,
        CustomerSetupFactory         $customerSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->eavConfig            = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository  = $attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $this->addCustomerAttribute($setup);
        }

        $setup->endSetup();
    }

    /**
     * Add the attribute "training_seller_id" on the customer model
     *
     * @param ModuleDataSetupInterface $setup
     */
    protected function addCustomerAttribute(ModuleDataSetupInterface $setup)
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
        $attribute->getResource()->save();

        $this->eavConfig->clear();
    }
}
