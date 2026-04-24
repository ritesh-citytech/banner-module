<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;

abstract class AbstractBanner extends Action
{
    public const ADMIN_RESOURCE = 'Citytech_Banner::manage';
}
