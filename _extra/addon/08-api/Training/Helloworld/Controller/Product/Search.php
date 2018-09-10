<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Raw as ResultRaw;
use Magento\Framework\Controller\ResultFactory;

/**
 * Product Controller, action Search
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Search extends Action
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @param Context                    $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder      $searchCriteriaBuilder
     * @param FilterBuilder              $filterBuilder
     * @param SortOrderBuilder           $sortOrderBuilder
     */
    public function __construct(
        Context                    $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder      $searchCriteriaBuilder,
        FilterBuilder              $filterBuilder,
        SortOrderBuilder           $sortOrderBuilder
    ) {
        parent::__construct($context);

        $this->productRepository     = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $products = $this->getProductList();

        $html = '<ul>';
        foreach ($products as $product) {
            $html.= '<li>' . $product->getSku() . ' => ' . $product->getName() . '</li>';
        }
        $html.= '</ul>';

        /** @var ResultRaw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($html);

        return $result;
    }

    /**
     * Get the list of the products to display
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    protected function getProductList()
    {
        $filterDesc = [];
        $filterDesc[] = $this->filterBuilder
            ->setField('description')
            ->setConditionType('like')
            ->setValue('%comfortable%')
            ->create();

        $filterName = [];
        $filterName[] = $this->filterBuilder
            ->setField('name')
            ->setConditionType('like')
            ->setValue('%Bruno%')
            ->create();

        $sortOrder = $this->sortOrderBuilder
            ->setField('name')
            ->setDescendingDirection()
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filterDesc)
            ->addFilters($filterName)
            ->addSortOrder($sortOrder)
            ->setPageSize(6)
            ->setCurrentPage(1)
            ->create();

        return $this->productRepository
            ->getList($searchCriteria)
            ->getItems();
    }
}
