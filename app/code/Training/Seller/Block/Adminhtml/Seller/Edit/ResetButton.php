<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Adminhtml\Seller\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Adminhtml block : Button Reset
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class ResetButton extends AbstractButton implements ButtonProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getButtonData()
    {
        return [
            'label'      => __('Reset'),
            'class'      => 'reset',
            'on_click'   => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}
