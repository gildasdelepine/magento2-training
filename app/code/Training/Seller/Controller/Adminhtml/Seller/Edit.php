<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Framework\Controller\ResultFactory;

/**
 * Admin Action : seller/edit
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Edit extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $modelId = (int) $this->getRequest()->getParam('seller_id');
        $model = $this->initModel($modelId);

        /** @var ResultPage $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $breadcrumbTitle = $model->getSellerId() ? __('Edit Seller') : __('New Seller');

        $resultPage
            ->setActiveMenu('Training_Seller::manage')
            ->addBreadcrumb(__('Sellers'), __('Sellers'))
            ->addBreadcrumb($breadcrumbTitle, $breadcrumbTitle);

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Sellers'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getSellerId()
            ? __("Edit Seller #%1", $model->getIdentifier())
            : __('New Seller')
        );

        return $resultPage;
    }
}
