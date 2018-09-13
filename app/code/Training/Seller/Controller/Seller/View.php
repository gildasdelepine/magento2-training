<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Raw as ResultRaw;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;

/**
 * Action: view
 */
class view extends AbstractAction
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        // get the asked identifier
        $identifier = trim($this->getRequest()->getParam('identifier'));
        if (!$identifier) {
            throw new NotFoundException(__('The identifier is missing'));
        }

        // get the asked seller
        try {
            $seller = $this->sellerRepository->getByIdentifier($identifier);
        } catch (NoSuchEntityException $e) {
            throw new NotFoundException(__('The identifier does not exist'));
        }

        $html = '
<h1>'.$seller->getName().'</h1>
<hr />
<p>#'.$seller->getIdentifier().'</p>
<hr />
<a href="/sellers.html">back to the list</a>
';

        /** @var ResultRaw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($html);

        return $result;
    }
}
