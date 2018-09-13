<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\ResultFactory;
use Training\Seller\Model\Seller;

/**
 * Admin Action : seller/inlineEdit
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class InlineEdit extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $error = false;
        $messages = [];

        if (!$this->getRequest()->getParam('isAjax')) {
            $messages[] = __('Ajax call needed.');
            $error = true;
            return $this->getResult($messages, $error);
        }

        $postItems = $this->getRequest()->getParam('items', []);
        if (!count($postItems)) {
            $messages[] = __('Please correct the data sent.');
            $error = true;
            return $this->getResult($messages, $error);
        }

        foreach (array_keys($postItems) as $modelId) {
            try {
                // load the seller
                $model = $this->modelRepository->getById((int) $modelId);

                /** @var Seller $model */
                $model->populateFromArray($postItems[$modelId]);

                // save the seller
                $this->modelRepository->save($model);
            } catch (\Exception $e) {
                $messages[] = '[Seller #'.$modelId.'] ' . __($e->getMessage());
                $error = true;
            }
        }

        return $this->getResult($messages, $error);
    }

    /**
     * Get the result
     *
     * @param string[] $messages
     * @param bool     $error
     *
     * @return ResultJson
     */
    protected function getResult($messages, $error)
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );

        return $resultJson;
    }
}
