<?php

declare(strict_types=1);

namespace Citytech\Banner\Model;

use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(\Citytech\Banner\Model\ResourceModel\Banner::class);
    }
}
