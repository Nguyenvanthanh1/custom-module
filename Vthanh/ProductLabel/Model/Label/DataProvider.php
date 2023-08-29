<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Vthanh\ProductLabel\Model\Label;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Vthanh\ProductLabel\Model\Label;
use Vthanh\ProductLabel\Model\ResourceModel\Label\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;


    public function __construct(
        CollectionFactory $collection,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection->create();
    }

    public function getData()
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }
        $data = $this->collection->getItems();
        foreach ($data as $label) {
            /**
             * @var Label $label
             */
            $this->loadedData[$label->getLabelId()] = $label->getData();
            unset($this->loadedData[$label->getLabelId()]['image_label']);
        }
        return $this->loadedData;
    }

}
