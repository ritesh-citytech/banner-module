<?php

declare(strict_types=1);

namespace Citytech\Banner\Ui\Component\Listing\Column;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        private readonly StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $mediaBaseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            foreach ($dataSource['data']['items'] as & $item) {
                if (empty($item['image'])) {
                    continue;
                }

                $url = $mediaBaseUrl . ltrim((string)$item['image'], '/');
                $item[$this->getData('name') . '_src'] = $url;
                $item[$this->getData('name') . '_orig_src'] = $url;
                $item[$this->getData('name') . '_alt'] = $item['title'] ?? '';
                $item[$this->getData('name') . '_link'] = '#';
            }
        }

        return $dataSource;
    }
}
