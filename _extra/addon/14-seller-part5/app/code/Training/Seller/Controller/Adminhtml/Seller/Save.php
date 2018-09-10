<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect as ResultRedirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Training\Seller\Api\Data\SellerInterfaceFactory as SellerFactory;
use Training\Seller\Api\SellerRepositoryInterface as SellerRepository;
use Training\Seller\Model\Seller;

/**
 * Admin Action : seller/save
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Save extends AbstractAction
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context                $context
     * @param Registry               $coreRegistry
     * @param SellerFactory          $modelFactory
     * @param SellerRepository       $modelRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context                $context,
        Registry               $coreRegistry,
        SellerFactory          $modelFactory,
        SellerRepository       $modelRepository,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context, $coreRegistry, $modelFactory, $modelRepository);

        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var ResultRedirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');

        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();
        if (empty($data)) {
            return $resultRedirect;
        }
        $this->dataPersistor->set('training_seller_seller', $data);

        // get the seller id (if edit)
        $sellerId = null;
        if (!empty($data['seller_id'])) {
            $sellerId = (int) $data['seller_id'];
        }

        // load the seller
        $model = $this->initModel($sellerId);

        // by default, redirect to the edit page of the seller
        $resultRedirect->setPath('*/*/edit', ['seller_id' => $sellerId]);

        /** @var Seller $model */
        $model->populateFromArray($data);


        // try to save it
        try {
            $this->modelRepository->save($model);
            if ($sellerId === null) {
                $resultRedirect->setPath('*/*/edit', ['seller_id' => $model->getSellerId()]);
            }

            // display success message
            $this->messageManager->addSuccessMessage(__('The seller has been saved.'));
            $this->dataPersistor->clear('training_seller_seller');

            // if not go back => redirect to the list
            if (!$this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('*/*/');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('Something went wrong while saving the seller. %1', $e->getMessage())
            );
        }

        return $resultRedirect;
    }
}
