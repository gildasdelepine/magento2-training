<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Api\Data\SellerInterfaceFactory;
use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Install Data
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var SellerInterfaceFactory
     */
    protected $sellerFactory;

    /**
     * @var SellerRepositoryInterface
     */
    private $sellerRepository;

    /**
     * @param SellerRepositoryInterface $sellerRepository
     * @param SellerInterfaceFactory    $sellerFactory
     */
    public function __construct(
        SellerRepositoryInterface $sellerRepository,
        SellerInterfaceFactory    $sellerFactory
    ) {
        $this->sellerRepository = $sellerRepository;
        $this->sellerFactory    = $sellerFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var SellerInterface $model */
        $model = $this->sellerFactory->create();
        $model->setIdentifier('main')->setName('Main Seller');

        $this->sellerRepository->save($model);
    }
}
