<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\Model\View\Result\Page as ResultPage;
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
        $breadMain = __('Manage Sellers');

        /** @var ResultPage $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Training_Seller::manage');
        $resultPage->getConfig()->getTitle()->prepend($breadMain);

        return $resultPage;
    }
}
