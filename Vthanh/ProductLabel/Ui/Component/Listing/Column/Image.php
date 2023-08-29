<?php

namespace Vthanh\ProductLabel\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Vthanh\ProductLabel\Helper\Data as LabelHelper;
use Magento\Framework\UrlInterface;

class Image extends Column
{

    const ALT_FIELD = 'name';
    private $helperLabel;
    private $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        LabelHelper $helperLabel,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->helperLabel = $helperLabel;
        $this->urlBuilder = $urlBuilder;
    }

    public function prepareDataSource(array $dataSource)
    {
        $fileName = $this->getName();
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$fileName . '_src'] = $this->helperLabel->getUrl() . DIRECTORY_SEPARATOR . $item[$fileName];
                $item[$fileName . '_orig_src'] = $this->helperLabel->getUrl() . DIRECTORY_SEPARATOR . $item[$fileName];
                $item[$fileName . '_link'] = $this->urlBuilder->getUrl('plabel/label/edit',
                    ['id' => $this->getData('label_id'), 'store' => $this->getContext()->getRequestParam('store')]);
                $item[$fileName . '_alt'] = $this->getAlt();
            }
        }
        return $dataSource;
    }

    protected function getAlt()
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? null;
    }
}
