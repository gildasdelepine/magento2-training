<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Raw as ResultRaw;
use Magento\Framework\Controller\ResultFactory;
use Training\Shop\Api\Config\ShopInterface as ShopConfigInterface;

/**
 * Shop Controller, action Index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Index extends Action
{
    /**
     * @var ShopConfigInterface
     */
    protected $shopConfig;

    /**
     * @param Context             $context
     * @param ShopConfigInterface $shopConfig
     */
    public function __construct(Context $context, ShopConfigInterface $shopConfig)
    {
        parent::__construct($context);

        $this->shopConfig = $shopConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $html = '<pre>' . print_r($this->shopConfig->getShops(), true) . '</pre><hr />';
        $html.= '<pre>' . print_r($this->shopConfig->getShop('sh01'), true) . '</pre><hr />';

        /** @var ResultRaw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($html);
        return $result;
    }
}
