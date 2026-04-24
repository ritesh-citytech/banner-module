<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Citytech\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Controller\ResultInterface;

class MassDelete extends AbstractBanner
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        private readonly CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $ids = (array)$this->getRequest()->getParam('selected', []);
        $excluded = $this->getRequest()->getParam('excluded');

        if ($excluded === 'false') {
            $ids = $this->collectionFactory->create()->getAllIds();
        }

        if (empty($ids)) {
            $this->messageManager->addErrorMessage(__('Please select banner(s).'));
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        try {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('banner_id', ['in' => $ids]);

            foreach ($collection as $item) {
                $item->delete();
            }

            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($ids)));
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Unable to delete selected banners.'));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
