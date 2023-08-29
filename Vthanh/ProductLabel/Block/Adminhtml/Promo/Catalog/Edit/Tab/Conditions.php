<?php

namespace Vthanh\ProductLabel\Block\Adminhtml\Promo\Catalog\Edit\Tab;

use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Renderer\Fieldset;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Rule\Model\Condition\AbstractCondition;
use Vthanh\ProductLabel\Api\Data\LabelInterface;

/**
 * Conditions
 * @package Vthanh\ProductLabel\Block\Adminhtml\Promo\Catalog\Edit\Tab
 */
class Conditions extends \Magento\Backend\Block\Widget\Form implements TabInterface
{
    /**
     * @var \Magento\Framework\Data\FormFactory
     */
    private $formFactory;

    /**
     * @var \Magento\Rule\Block\Conditions
     */
    private $conditions;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;


    /**
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Rule\Block\Conditions $conditions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     * @param Form\Element\ElementCreator|null $creator
     */
    public function __construct(
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Rule\Block\Conditions $conditions,
        \Magento\Backend\Block\Template\Context $context,
        array $data = [],
        Form\Element\ElementCreator $creator = null,
    ) {
        parent::__construct($context, $data, $creator);
        $this->formFactory = $formFactory;
        $this->conditions = $conditions;
        $this->registry = $registry;
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabLabel()
    {
        return __('Label Conditions');
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabTitle()
    {
        return __('Label Conditions');

    }

    /**
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return false
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Conditions
     */
    protected function _prepareForm()
    {
        $model = $this->registry->registry('current_label_rule');
        /** @var \Magento\Framework\Data\Form $form
         * @var LabelInterface $model
         */
        $form = $this->addTabToForm($model);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * @param LabelInterface $model
     * @param string $fieldsetId
     * @param string $formName
     * @return \Magento\Framework\Data\Form
     * @throws LocalizedException
     */
    public function addTabToForm(LabelInterface $model, string $fieldsetId = 'conditions_fieldset', string $formName = 'label_form')
    {
        /** @var Form $form */
        $formCondition = $this->formFactory->create();
        $formCondition->setHtmlIdPrefix('rule_');
        $conditionsFieldSetId = $model->getConditionsFieldSetId($formName);

        $newChildUrl = $this->getUrl(
            'plabel/label_rule/newConditionHtml/form/' . $conditionsFieldSetId,
            ['form_namespace' => $formName]
        );
        $renderer = $this->getLayout()->createBlock(Fieldset::class);
        $renderer->setTemplate('Magento_CatalogRule::promo/fieldset.phtml')
            ->setNewChildUrl($newChildUrl)
            ->setFieldSetId($conditionsFieldSetId);

        $fieldset = $formCondition->addFieldset(
            $fieldsetId,
            ['legend' => __('Conditions (don\'t add conditions if rule is applied to all products)')]
        )->setRenderer($renderer);

        $fieldset->addField(
            'conditions',
            'text',
            [
                'name' => 'conditions',
                'label' => __('Label Conditions'),
                'title' => __('Label Conditions'),
                'required' => true,
                'data-form-part' => $formName
            ]
        )
            ->setRule($model)
            ->setRenderer($this->conditions);

        $formCondition->setValues($model->getData());
        $this->setConditionFormName($model->getConditions(), $formName, $conditionsFieldSetId);
        return $formCondition;

    }

    /**
     * @param AbstractCondition $conditions
     * @param $formName
     * @param $jsFormName
     * @return void
     */
    private function setConditionFormName(AbstractCondition $conditions, $formName, $jsFormName)
    {
        $conditions->setFormName($formName);
        $conditions->setJsFormObject($jsFormName);

        if ($conditions->getConditions() && is_array($conditions->getConditions())) {
            foreach ($conditions->getConditions() as $condition) {
                $this->setConditionFormName($condition, $formName, $jsFormName);
            }
        }
    }
}
