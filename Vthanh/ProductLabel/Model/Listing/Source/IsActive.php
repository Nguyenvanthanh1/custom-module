<?php

namespace Vthanh\ProductLabel\Model\Listing\Source;

use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{

    public function toOptionArray()
    {
        return [
            [
                'value' => 1,
                'label' => __('Enable'),
            ],
            [
                'value' => 0,
                'label' => __('Disable')
            ],
        ];
    }
}
