<?php

namespace Vthanh\ProductLabel\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Asset\Repository;

class Image extends Template
{

    private $assetRepo;

    public function __construct(Repository $assetRepo, Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->assetRepo = $assetRepo;
    }

    public function getDefaultUrl()
    {
        return $this->assetRepo->getUrl("Magento_Catalog::images/product/placeholder/image.jpg");
    }

}
