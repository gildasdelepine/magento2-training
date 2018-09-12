<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Api\Data\SellerInterfaceFactory;
use Training\Seller\Api\SellerRepositoryInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var SellerRepositoryInterface
     */
    private $sellerRepository;
    /**
     * @var SellerInterfaceFactory
     */
    private $sellerFactory;

    /**
     * @param SellerRepositoryInterface $sellerRepository
     * @param SellerInterfaceFactory $sellerFactory
     */
    public function __construct(
        SellerRepositoryInterface $sellerRepository,
        SellerInterfaceFactory $sellerFactory
    ) {
        $this->sellerRepository = $sellerRepository;
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var SellerInterface $model */
        $model = $this->sellerFactory->create();
        $model->setIdentifier('main')->setName('Main Seller');

        $this->sellerRepository->save($model);
    }
}