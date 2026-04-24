<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Citytech\Banner\Model\BannerFactory;
use Magento\Framework\Controller\ResultInterface;

class Delete extends AbstractBanner
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        private readonly BannerFactory $bannerFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $id = (int)$this->getRequest()->getParam('banner_id');
        if (!$id) {
            $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        try {
            $banner = $this->bannerFactory->create()->load($id);
            $banner->delete();
            $this->messageManager->addSuccessMessage(__('The banner has been deleted.'));
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Unable to delete banner right now.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/edit', ['banner_id' => $id]);
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
