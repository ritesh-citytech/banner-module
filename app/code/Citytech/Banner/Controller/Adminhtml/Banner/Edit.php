<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Citytech\Banner\Model\BannerFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;

class Edit extends AbstractBanner
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        private readonly BannerFactory $bannerFactory,
        private readonly Registry $coreRegistry
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $id = (int)$this->getRequest()->getParam('banner_id');
        $banner = $this->bannerFactory->create();

        if ($id) {
            $banner->load($id);
            if (!$banner->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
        }

        $this->coreRegistry->register('citytech_banner', $banner);

        $resultPage = $this->resultFactory->create(self::RESULT_PAGE);
        $resultPage->setActiveMenu('Citytech_Banner::manage');
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Banner') : __('New Banner'));

        return $resultPage;
    }
}
