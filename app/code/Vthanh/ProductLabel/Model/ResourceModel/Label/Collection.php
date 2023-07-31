<?php

namespace Vthanh\ProductLabel\Model\ResourceModel\Label;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vthanh\ProductLabel\Model\Label as Model;
use Vthanh\ProductLabel\Model\ResourceModel\Label as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'vthanh_label_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
