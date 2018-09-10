<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

use Magento\Framework\Controller\Result\Raw as ResultRaw;
use Magento\Framework\Controller\ResultFactory;

/**
 * Action : seller/index
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
        $searchCriteria = $this->getSearchCriteria();

        // get the list of the sellers
        $searchResult = $this->sellerRepository->getList($searchCriteria);

        $html = '<ul>';
        foreach ($searchResult->getItems() as $seller) {
            $html.= '<li><a href="/seller/'.$seller->getIdentifier().'.html">'.$seller->getName().'</a></li>';
        }
        $html.= '</ul>';

        /** @var ResultRaw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($html);

        return $result;
    }

    /**
     * Get the search criteria
     *
     * @return \Magento\Framework\Api\SearchCriteria
     */
    protected function getSearchCriteria()
    {
        // build the criteria
        return $this->searchCriteriaBuilder->create();
    }
}
