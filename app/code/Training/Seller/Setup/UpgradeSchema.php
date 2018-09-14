<?php
/**
 * Module Training/Seller
 */

namespace Training\Seller\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Training\Seller\Api\Data\SellerInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @inheritdoc}
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->addFieldDescription($setup);
        }
        $setup->endSetup();
    }

    protected function addFieldDescription(SchemaSetupInterface $setup) {
        $tableName = $setup->getTable(SellerInterface::TABLE_NAME);

        $setup->getConnection()->addColumn(
            $tableName,
            SellerInterface::FIELD_DESCRIPTION,
            [
                'type'     => Table::TYPE_TEXT,
                'length'   => null,
                'nullable' => true,
                'comment'  => 'Seller Description',
            ]
        );
    }
}
