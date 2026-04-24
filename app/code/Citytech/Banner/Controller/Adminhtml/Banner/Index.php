<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractBanner
{
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultFactory->create(self::RESULT_PAGE);
        $resultPage->setActiveMenu('Citytech_Banner::manage');
        $resultPage->getConfig()->getTitle()->prepend(__('Banners'));

        return $resultPage;
    }
}
