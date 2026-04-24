<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultInterface;

class NewAction extends AbstractBanner
{
    public function execute(): ResultInterface
    {
        return $this->resultRedirectFactory->create()->setPath('*/*/edit');
    }
}
