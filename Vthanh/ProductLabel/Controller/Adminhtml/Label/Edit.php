<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Vthanh\ProductLabel\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Vthanh\ProductLabel\Api\Data\LabelInterface;
use Vthanh\ProductLabel\Model\LabelFactory;
use Vthanh\ProductLabel\Api\LabelRepositoryInterface;
use Magento\Backend\Model\Session;

class Edit extends Action implements HttpGetActionInterface
{
    protected $registry;
    protected $labelFactory;
    protected $labelRepository;
    protected $sessionBackend;

    /**
     * @param Session $sessionBackend
     * @param LabelRepositoryInterface $labelRepository
     * @param LabelFactory $labelFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        Session $sessionBackend,
        LabelRepositoryInterface $labelRepository,
        LabelFactory $labelFactory,
        Registry $registry,
        Context $context
    ) {
        parent::__construct($context);
        $this->registry = $registry;
        $this->labelFactory = $labelFactory;
        $this->labelRepository = $labelRepository;
        $this->sessionBackend = $sessionBackend;
    }

    public function execute(): ResultInterface
    {
        /**
         * @var LabelInterface $modelLabel
         */
        $modelLabel = $this->labelFactory->create();
        $labelId = $this->getRequest()->getParam('id');
        if ($labelId) {
            try {
                $modelLabel = $this->labelRepository->get($this->getRequest()->getParam('id'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This rule no longer exists.'));
                $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
        }
        $data = $this->sessionBackend->getPageData(true);
        if ($data) {
            $modelLabel->addData($data);
        }
        $modelLabel->getConditions()->setFormName('label_form');
        $modelLabel->getConditions()->setJsFormObject($modelLabel->getConditionsFieldSetId($modelLabel->getConditions()->getFormName()));

        $this->registry->register('current_label_rule', $modelLabel);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend($modelLabel->getLabelId() ? __('Form Edit Label') : __('Form New Label'));
        return $resultPage;
    }
}
