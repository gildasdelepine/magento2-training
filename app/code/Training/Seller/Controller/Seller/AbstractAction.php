<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
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

    /** @var Registry $registry */
    protected $registry;


    /**
     * @param Context $context
     * @param SellerRepositoryInterface $sellerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Registry $registry
     */
    public function __construct(
        Context                   $context,
        SellerRepositoryInterface $sellerRepository,
        SearchCriteriaBuilder     $searchCriteriaBuilder,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->sellerRepository      = $sellerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->registry              = $registry;
    }
}