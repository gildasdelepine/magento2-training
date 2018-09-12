<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Api\SellerRepositoryInterface;
use Training\Seller\Api\Data\SellerInterfaceFactory;

class InstallData implements InstallDataInterface
{
    /** @var SellerInterfaceFactory */
    protected $sellerFactory;

    /** @var SellerRepositoryInterface */
    protected $sellerRepository;

    /**
     * @param SellerRepositoryInterface $sellerRepository
     * @param SellerInterfaceFactory $sellerFactory
     */
    public function _construct(
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