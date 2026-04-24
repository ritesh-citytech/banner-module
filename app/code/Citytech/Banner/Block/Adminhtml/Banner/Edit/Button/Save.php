<?php

declare(strict_types=1);

namespace Citytech\Banner\Block\Adminhtml\Banner\Edit\Button;

use Citytech\Banner\Block\Adminhtml\Banner\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Save Banner'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'save'],
                ],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
