<?php

declare(strict_types=1);

namespace Citytech\Banner\Block\Adminhtml\Banner\Edit\Button;

use Citytech\Banner\Block\Adminhtml\Banner\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveAndContinue extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
                'form-role' => 'save',
            ],
            'sort_order' => 80,
        ];
    }
}
