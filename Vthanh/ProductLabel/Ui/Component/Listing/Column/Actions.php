<?php

namespace Vthanh\ProductLabel\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Vthanh\ProductLabel\Helper\Data as LabelHelper;

class Actions extends Column
{

    private $labelHelper;

    public function __construct(
        LabelHelper $labelHelper,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->labelHelper = $labelHelper;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $storeId = $this->context->getFilterParam('store_id');
                // here we can also use the data from $item to configure some parameters of an action URL
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->labelHelper->getActionUrl('edit', [
                            'id' => $item['label_id'],
                            'store' => $storeId
                        ]),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->labelHelper->getActionUrl('delete', [
                            'id' => $item['label_id'],
                            'store' => $storeId
                        ]),
                        'label' => __('Delete')
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
