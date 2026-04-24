<?php

declare(strict_types=1);

namespace Citytech\Banner\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class BannerActions extends Column
{
    private const URL_PATH_EDIT = 'citytech_banner/banner/edit';
    private const URL_PATH_DELETE = 'citytech_banner/banner/delete';

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        private readonly Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $id = (int)($item['banner_id'] ?? 0);
                if (!$id) {
                    continue;
                }
                $title = $this->escaper->escapeHtmlAttr((string)($item['title'] ?? ''));
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['banner_id' => $id]),
                        'label' => __('Edit'),
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['banner_id' => $id]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "%1"', $title),
                            'message' => __('Are you sure you want to delete "%1"?', $title),
                        ],
                        'post' => true,
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
