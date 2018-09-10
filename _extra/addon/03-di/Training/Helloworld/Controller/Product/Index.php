<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Raw as ResultRaw;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

/**
 * Action: Product/Index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Index extends Action
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @param Context $context
     * @param ProductFactory $productFactory
     */
    public function __construct(Context $context, ProductFactory $productFactory)
    {
        parent::__construct($context);

        $this->productFactory = $productFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $product = $this->getProduct();
        if ($product === null) {
            throw new NotFoundException(__('product not found'));
        }

        /** @var ResultRaw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents('Product: ' . $product->getName());

        return $result;
    }

    /**
     * Get the requested product
     *
     * @return Product|null
     */
    protected function getProduct()
    {
        // get the requested id
        $productId = (int) $this->getRequest()->getParam('id');
        if (!$productId) {
            return null;
        }

        // get the product
        $product = $this->productFactory->create();
        $product->getResource()->load($product, $productId);
        if (!$product->getId()) {
            return null;
        }

        return $product;
    }
}
