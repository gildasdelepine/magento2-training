<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Framework\Controller\Result\Raw as ResultRaw;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action : seller/index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Index extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $model = $this->modelRepository->getByIdentifier('main');
        $html = 'Seller: '.$model->getName();

        /** @var ResultRaw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($html);

        return $result;
    }
}
