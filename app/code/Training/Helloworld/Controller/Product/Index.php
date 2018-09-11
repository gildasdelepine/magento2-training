<?php
/**
 * Created by PhpStorm.
 * User: training
 * Date: 9/10/18
 * Time: 5:15 PM
 */
namespace Training\Helloworld\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\ProductFactory as ProductFactory;
use Magento\Catalog\Model\Product as Product;
use Magento\Framework\Exception\NotFoundException;
use Psr\Log\LoggerInterface;

class Index extends Action
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param ProductFactory $productFactory
     */
    public function __construct(Context $context, ProductFactory $productFactory)
    {
        parent::__construct($context);
        $this->productFactory = $productFactory;
    }


    /**
     * Get the requested product
     *
     * @return Product|null
     * @throws NotFoundException
     */
    protected function getProduct() {
        // requested id - need to be (int) => cast
        $pid = (int) $this->getRequest()->getParam('id');
        if(!$pid) {
            throw new NotFoundException(__('product id not found'));
        }

        // !!!!! Log info about a object => Production debug ->result visible in /var/log/system/log !!!!!
        ObjectManager::getInstance()->get(LoggerInterface::class)->info($pid);

        // get the product
        $product = $this->productFactory->create();
        $product->getResource()->load($product, $pid);

        if(!$product->getId()) {
            throw new NotFoundException(__('product not found'));
        }

        return $product;

    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $product = $this->getProduct();

        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents('Product : '. $product->getName());

        return $result;
    }
}