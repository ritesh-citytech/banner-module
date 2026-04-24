<?php

declare(strict_types=1);

namespace Citytech\Banner\Controller\Adminhtml\Banner;

use Citytech\Banner\Model\BannerFactory;
use Citytech\Banner\Model\ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends AbstractBanner
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        private readonly BannerFactory $bannerFactory,
        private readonly ImageUploader $imageUploader,
        private readonly DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }

        $id = (int)$this->getRequest()->getParam('banner_id');
        $model = $this->bannerFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
        }

        try {
            if (isset($data['image'][0]['name'])) {
                $imageName = (string)$data['image'][0]['name'];
                if (str_contains($imageName, '/')) {
                    $data['image'] = $imageName;
                } else {
                    $data['image'] = $this->imageUploader->moveFileFromTmp($imageName);
                }
            } else {
                unset($data['image']);
            }

            $model->addData($data);
            $model->save();
            $this->dataPersistor->clear('citytech_banner');

            $this->messageManager->addSuccessMessage(__('The banner has been saved.'));
            if ($this->getRequest()->getParam('back')) {
                return $this->resultRedirectFactory->create()->setPath('*/*/edit', ['banner_id' => $model->getId()]);
            }

            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Something went wrong while saving the banner.'));
        }

        $this->dataPersistor->set('citytech_banner', $data);

        return $this->resultRedirectFactory->create()->setPath('*/*/edit', ['banner_id' => $id]);
    }
}
