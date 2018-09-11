<?php

namespace Training\Helloworld\Controller\Product;


use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\Product as ProductModel;
use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Categories extends Action
{
    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;
    /**
     * @var CategoryCollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * Categories constructor.
     * @param Context $context
     * @param ProductCollectionFactory $productCollectionFactory
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory)
    {
        parent::__construct($context);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     *
     */
    public function execute() {
        /** @var ProductCollection $productCollection */
        $productCollection = $this->productCollectionFactory->create();
        $productCollection
            ->addAttributeToFilter('name', ['like' => '%bag%'])
            ->load()
            ->addCategoryIds();

        $categoryIds = [];
        foreach ($productCollection->getItems() as $product) {
            /** @var ProductModel $product */
            $categoryIds = array_merge($categoryIds, $product->getCategoryIds());
        }
        $categoryIds = array_unique($categoryIds);

        /** @var Categorycollection $categoryCollection */
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection
            ->addAttributeToFilter('entity_id', array('in' => $categoryIds))
            ->addAttributeToSelect('name')
            ->load();

        $html = '<ul>';
        foreach ($productCollection->getItems() as $product) {
            $html.= '<li>';
            $html.= $product->getId() . ' => ' . $product->getSku() . ' => ' . $product->getName();
            $html.= '<ul>';
            foreach ($product->getCategoryIds() as $categoryId) {
                /** @var CategoryModel $category */
                $category = $categoryCollection->getItemById($categoryId);
                $html.= '<li>' . $categoryId . ' => ' . $category->getName() . '</li>';
            }
            $html.= '</ul>';
            $html.= '</li>';
        }
        $html.= '</ul>';
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($html);
        return $result;

    }
}