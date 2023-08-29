<?php

namespace Vthanh\ProductLabel\Model;

use Magento\CatalogRule\Model\Rule\Action\CollectionFactory as RuleCollectionFactory;
use Magento\CatalogRule\Model\Rule\Condition\CombineFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Vthanh\ProductLabel\Api\Data\LabelInterface;
use Vthanh\ProductLabel\Model\ResourceModel\Label as ResourceModel;

class Label extends \Magento\Rule\Model\AbstractModel implements LabelInterface
{
    protected $combineFactory;
    protected $actionCollectionFactory;

    public function __construct(
        CombineFactory $combineFactory,
        RuleCollectionFactory $actionCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        ExtensionAttributesFactory $extensionFactory = null,
        AttributeValueFactory $customAttributeFactory = null,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null
    ) {
        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data,
            $extensionFactory, $customAttributeFactory, $serializer);
        $this->combineFactory = $combineFactory;
        $this->actionCollectionFactory = $actionCollectionFactory;
    }

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
        $this->setIdFieldName('label_id');
    }

    public function getConditionsInstance()
    {
        return $this->combineFactory->create();
    }

    public function getActionsInstance()
    {
        return $this->actionCollectionFactory->create();
    }

    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    public function getLabelId(): mixed
    {
        return $this->getData('label_id');
    }

    public function setLabelId($labelId): void
    {
        $this->setData('label_id', $labelId);
    }

    public function getTitle(): string
    {
        return $this->getData('title');
    }

    public function setTitle(string $title): void
    {
        $this->setData('title', $title);
    }

    public function setIsActive(bool $status): void
    {
        $this->setData('is_active', $status);
    }

    public function getIsActive(): bool
    {
        return $this->getData('is_active');
    }

    public function getFormDate(): string
    {
        return $this->getData('from_date');
    }

    public function setFormDate(string $formDate): void
    {
        $this->setData('from_date', $formDate);
    }

    public function getToDate(): string
    {
        return $this->getData('to_date');
    }

    public function setToDate(string $toDate): void
    {
        $this->setData('to_date', $toDate);
    }

    public function getImageLabel(): string
    {
        return $this->getData('image_label');
    }

    public function setImageLabel($image): void
    {
        $this->setData('image_label', $image);
    }

    public function beforeSave()
    {
        // Serialize conditions
        if ($this->getConditions()) {
            $this->setConditionsSerialized($this->serializer->serialize($this->getConditions()->asArray()));
            $this->_conditions = null;
        }
        // Serialize actions
        if ($this->getActions()) {
            $this->setActionsSerialized($this->serializer->serialize($this->getActions()->asArray()));
            $this->_actions = null;
        }
    }

    public function afterSave()
    {
        if ($this->hasStoreIds()) {
            $this->getResource()->bindLabelToEntity($this->getId(), $this->getStoreIds(), 'store');
        }
        return parent::afterSave();
    }

    public function setConditionsSerialized(string $combine)
    {
        $this->setData('conditions_serialized', $combine);
    }

    public function getConditionsSerialized(): string
    {
        return $this->getData('conditions_serialized');
    }

    public function setActionsSerialized(string $combine)
    {
        $this->setData('actions_serialized', $combine);
    }

    public function getActionsSerialized(): string
    {
        return $this->getData('actions_serialized');
    }
}
