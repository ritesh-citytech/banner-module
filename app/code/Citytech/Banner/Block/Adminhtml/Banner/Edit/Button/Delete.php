<?php

declare(strict_types=1);

namespace Citytech\Banner\Block\Adminhtml\Banner\Edit\Button;

use Citytech\Banner\Block\Adminhtml\Banner\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Delete extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getBannerId()) {
            $data = [
                'label' => __('Delete Banner'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?') . '\', \''
                    . $this->getUrl('*/*/delete', ['banner_id' => $this->getBannerId()]) . '\', {data: {}})',
                'sort_order' => 20,
            ];
        }

        return $data;
    }
}
