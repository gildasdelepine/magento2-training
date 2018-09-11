<?php

namespace Training\Helloworld\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Raw as ResultRaw;

class Search extends Action
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder)
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

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


    protected function getProductList()
    {
        $filterDesc = [];
        $filterDesc[] = $this->filterBuilder
            ->setField('description')->setConditionType('like')->setValue('%comfortable%')
            ->create();

        $filterName = [];
        $filterName[] = $this->filterBuilder
            ->setField('name')->setConditionType('like')->setValue('%Bruno%')
            ->create();

        $sortOrder = [];
        $sortOrder[] = $this->sortOrderBuilder
            ->setField('name')->setDescendingDirection()
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filterDesc)
            ->addFilters($filterName)
            ->setSortOrders($sortOrder)
            ->setPageSize(6)
            ->setCurrentPage(1)
            ->create();

        return $this->productRepository->getList($searchCriteria)->getItems();
    }
}