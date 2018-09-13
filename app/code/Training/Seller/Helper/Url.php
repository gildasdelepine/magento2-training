<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Helper: Url
 */
class Url extends AbstractHelper
{
    /**
     * Get the url of the sellers
     *
     * @return string
     */
    public function getSellersUrl()
    {
        return $this->_urlBuilder->getDirectUrl('sellers.html');
    }

    /**
     * Get the url of a seller
     *
     * @param string $identifier
     *
     * @return string
     */
    public function getSellerUrl($identifier)
    {
        return $this->_urlBuilder->getDirectUrl('seller/'.$identifier.'.html');
    }
}
