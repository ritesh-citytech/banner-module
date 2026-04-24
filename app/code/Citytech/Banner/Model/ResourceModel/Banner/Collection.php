<?php

declare(strict_types=1);

namespace Citytech\Banner\Model\ResourceModel\Banner;

use Citytech\Banner\Model\Banner as BannerModel;
use Citytech\Banner\Model\ResourceModel\Banner as BannerResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(BannerModel::class, BannerResource::class);
    }
}
