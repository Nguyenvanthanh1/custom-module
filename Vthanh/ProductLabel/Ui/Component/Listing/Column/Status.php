<?php

namespace Vthanh\ProductLabel\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    public function prepareDataSource($dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item[$this->getName()] == 1) {
                    $item[$this->getName()] = "Active";
                } else {
                    $item[$this->getName()] = "Not Active";
                }
            }
        }
        return $dataSource;
    }
}
