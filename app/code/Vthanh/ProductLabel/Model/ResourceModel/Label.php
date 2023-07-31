<?php

namespace Vthanh\ProductLabel\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Label extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'vthanh_label_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('vthanh_label', 'label_id');
        $this->_useIsObjectNew = true;
    }
}
