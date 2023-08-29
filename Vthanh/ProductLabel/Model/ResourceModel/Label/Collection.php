<?php

namespace Vthanh\ProductLabel\Model\ResourceModel\Label;

use Magento\Framework\Event\ManagerInterface;
use Vthanh\ProductLabel\Model\Label as Model;
use Vthanh\ProductLabel\Model\ResourceModel\Label as ResourceModel;

class Collection extends \Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'vthanh_label_collection';

    protected $_associatedEntitiesMap;

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    public function __construct(
        array $associatedEntitiesMap,
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->_associatedEntitiesMap = $associatedEntitiesMap;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

}
