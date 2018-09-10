<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action : seller/massDelete
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class MassDelete extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/index');

        $sellerIds = $this->getRequest()->getParam('selected', []);

        if (!is_array($sellerIds) || count($sellerIds)<1) {
            $this->messageManager->addErrorMessage(__('Please select sellers.'));
            return $resultRedirect;
        }

        try {
            foreach ($sellerIds as $sellerId) {
                $this->modelRepository->deleteById((int) $sellerId);
            }
            $this->messageManager->addSuccessMessage(__('Total of %1 seller(s) were deleted.', count($sellerIds)));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect;
    }
}
