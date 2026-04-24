<?php

declare(strict_types=1);

namespace Citytech\Banner\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    public function __construct(private readonly Context $context)
    {
    }

    public function getBannerId(): int
    {
        return (int)$this->context->getRequest()->getParam('banner_id');
    }

    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
