<?php

namespace Vthanh\ProductLabel\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Label extends \Magento\Rule\Model\ResourceModel\AbstractResource

{
    /**
     * @var string
     */
    protected
        $_eventPrefix = 'vthanh_label_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('vthanh_label', 'label_id');
        $this->_useIsObjectNew = true;
    }

    public function __construct(
        array $associatedEntitiesMap,
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null,

    ) {
        $this->_associatedEntitiesMap = $associatedEntitiesMap;
        parent::__construct($context, $connectionName);
    }

    /**
     * @throws \Exception
     */
    public function bindLabelToEntity(
        $labelIds,
        $entityIds,
        $entityType
    ): static {
        $this->getConnection()->beginTransaction();

        try {
            $this->_multiplyBunchInsert($labelIds, $entityIds, $entityType);
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            throw $e;
        }

        $this->getConnection()->commit();

        return $this;
    }
}
