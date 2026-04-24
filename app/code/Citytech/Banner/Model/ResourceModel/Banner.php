<?php

declare(strict_types=1);

namespace Citytech\Banner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('citytech_banner', 'banner_id');
    }
}
