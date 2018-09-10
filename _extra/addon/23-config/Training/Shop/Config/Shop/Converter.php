<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Config\Shop;

use Magento\Framework\Config\ConverterInterface;

/**
 * Class Converter for shops.xml
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Converter implements ConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert($source)
    {
        $output = [];

        /** @var $shopNode \DOMNode */
        foreach ($source->getElementsByTagName('shop') as $shopNode) {
            $shopCode = $this->getAttributeValue($shopNode, 'code');

            $output[$shopCode] = [
                'code'    => $shopCode,
                'state'   => $this->getAttributeValue($shopNode, 'state'),
                'name'    => $this->getAttributeValue($shopNode, 'name'),
                'address' => $this->getAttributeValue($shopNode, 'address'),
                'city'    => $this->getAttributeValue($shopNode, 'city'),
            ];
        }
        return $output;
    }

    /**
     * Get attribute value
     *
     * @param \DOMNode    $node
     * @param string      $attributeName
     * @param string|null $defaultValue
     *
     * @return null|string
     */
    protected function getAttributeValue(\DOMNode $node, $attributeName, $defaultValue = null)
    {
        $attributeNode = $node->attributes->getNamedItem($attributeName);
        $output = $defaultValue;
        if ($attributeNode) {
            $output = $attributeNode->nodeValue;
        }
        return $output;
    }
}
