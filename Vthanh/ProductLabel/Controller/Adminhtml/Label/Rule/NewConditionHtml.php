<?php

namespace Vthanh\ProductLabel\Controller\Adminhtml\Label\Rule;

use Magento\Backend\App\Action\Context;
use Magento\CatalogRule\Controller\Adminhtml\Promo\Catalog;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Rule\Model\Condition\AbstractCondition;
use Magento\Rule\Model\Condition\ConditionInterface;
use Vthanh\ProductLabel\Model\LabelFactory;

class NewConditionHtml extends Catalog implements HttpPostActionInterface, HttpGetActionInterface
{

    private $labelFactory;

    public function __construct(LabelFactory $labelFactory, Context $context, Registry $coreRegistry, Date $dateFilter)
    {
        parent::__construct($context, $coreRegistry, $dateFilter);
        $this->labelFactory = $labelFactory;
    }

    public function execute()
    {
        $labelId = $this->getRequest()->getParam('id');
        $formNamespace = $this->getRequest()->getParam('form_namespace');
        $types = explode(
            '|',
            str_replace('-', '/', $this->getRequest()->getParam('type', ''))
        );

        $objectType = $types[0];
        $reponseBody = '';

        if (class_exists($objectType) && !in_array(ConditionInterface::class, class_implements($objectType))) {
            $this->getResponse()->setBody($reponseBody);
            return;
        }

        $conditionModel = $this->_objectManager->create($objectType)
            ->setId($labelId)
            ->setType($objectType)
            ->setRule($this->labelFactory->create())
            ->setPrefix('conditions');

        if (!empty($types[1])) {
            $conditionModel->setAttribute($types[1]);
        }

        if ($conditionModel instanceof AbstractCondition) {
            $conditionModel->setJsFormObject($this->getRequest()->getParam('form'));
            $conditionModel->setFormName($formNamespace);
            $reponseBody = $conditionModel->asHtmlRecursive();
        }

        $this->getResponse()->setBody($reponseBody);
    }
}
