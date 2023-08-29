<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Vthanh\ProductLabel\Ui\Component\Column;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Position
 * @package Vthanh\ProductLabel\Ui\Component\Column
 */
class Position implements OptionSourceInterface
{

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $positionArray = [];
        $positionArray[0] = [
            'label' => '__Select Position__',
            'value' => 0,
        ];
        if (!empty($this->_getSourcePosition())) {
            foreach ($this->_getSourcePosition() as $value) {
                $positionArray[] = array_merge($positionArray, [
                    'label' => $value,
                    'value' => strtolower($value)
                ]);
            }
        }
        return $positionArray;
    }

    /**
     * @return string[]
     */
    private function _getSourcePosition(): array
    {
        return ['Left', 'Right', 'Top', 'Bottom', 'Middle'];
    }
}
