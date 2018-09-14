<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Cron;

use Training\Seller\Api\SellerRepositoryInterface;
use Psr\Log\LoggerInterface;

class Logger
{
    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Logger constructor.
     * @param SellerRepositoryInterface $sellerRepository
     * @param LoggerInterface $logger
     */
    public function __construct(SellerRepositoryInterface $sellerRepository, LoggerInterface $logger)
    {
        $this->sellerRepository = $sellerRepository;
        $this->logger = $logger;
    }

    /**
     *
     */
    public function execute()
    {
        $count = $this->sellerRepository->getList()->getTotalCount();
        $this->logger->info("Nb sellers : ".$count);
    }
}
