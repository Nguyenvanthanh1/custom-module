<?php

namespace Vthanh\ProductLabel\Model;

use Magento\Framework\Model\AbstractModel;
use Vthanh\ProductLabel\Model\ResourceModel\Label as ResourceModel;

class Label extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'vthanh_label_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
