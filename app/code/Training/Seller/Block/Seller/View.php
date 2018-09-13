<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Block\Seller;


use Magento\Framework\DataObject\IdentityInterface;
use Training\Seller\Model\Seller;

class View extends AbstractBlock implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $seller = $this->getCurrentSeller();
        if ($seller) {
            $this->setData('cache_key', 'seller_view_' . $seller->getId());
            $this->setData('cache_lifetime', 600);
        }
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        $identities = [];

        $seller = $this->getCurrentSeller();
        if ($seller) {
            $identities = $seller->getIdentities();
        }

        return $identities;
    }

    /**
     * Get the current seller.
     *
     * @return Seller
     */
    public function getCurrentSeller() {
        return $currentSeller = $this->registry->registry('current_seller');
    }
}