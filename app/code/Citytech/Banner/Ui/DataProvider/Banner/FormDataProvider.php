<?php

declare(strict_types=1);

namespace Citytech\Banner\Ui\DataProvider\Banner;

use Citytech\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class FormDataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        private readonly CollectionFactory $collectionFactory,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $this->collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }

        foreach ($this->collection->getItems() as $banner) {
            $data = $banner->getData();
            if (!empty($data['image'])) {
                $data['image'] = [[
                    'name' => basename((string)$data['image']),
                    'url' => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $data['image'],
                ]];
            }
            $this->loadedData[$banner->getId()] = $data;
        }

        $data = $this->dataPersistor->get('citytech_banner');
        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getData();
            $this->dataPersistor->clear('citytech_banner');
        }

        return $this->loadedData;
    }
}
