<?php

namespace Vthanh\ProductLabel\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
use Vthanh\ProductLabel\Model\LabelFactory;

class Data extends AbstractHelper
{

    protected $storeManager;

    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        LabelFactory $labelFactory,
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
    }

    public function getUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $this->labelUrl();
    }

    public function labelUrl(): string
    {
        return 'product\label';
    }

    public function getActionUrl(string $action, array $params): string
    {
        return $this->urlBuilder->getUrl('plabel/label' . '/' . $action, $params);
    }
}
