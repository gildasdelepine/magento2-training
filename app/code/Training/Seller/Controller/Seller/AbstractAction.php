<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Controller abstract
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractAction extends Action
{
    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param Context                   $context
     * @param SellerRepositoryInterface $sellerRepository
     * @param SearchCriteriaBuilder     $searchCriteriaBuilder
     */
    public function __construct(
        Context                   $context,
        SellerRepositoryInterface $sellerRepository,
        SearchCriteriaBuilder     $searchCriteriaBuilder
    ) {
        $this->sellerRepository      = $sellerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

        parent::__construct($context);
    }
}