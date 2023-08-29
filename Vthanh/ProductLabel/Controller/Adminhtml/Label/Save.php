<?php

namespace Vthanh\ProductLabel\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Vthanh\ProductLabel\Api\LabelRepositoryInterface;
use Vthanh\ProductLabel\Model\LabelFactory;
use Magento\Framework\Filesystem\Driver\File;

class Save extends Action implements HttpPostActionInterface
{
    protected $labelRepository;
    protected $labelFactory;

    protected $dataPersistor;
    protected $fileManager;

    public function __construct(
        File $fileManager,
        DataPersistorInterface $dataPersistor,
        LabelFactory $labelFactory,
        LabelRepositoryInterface $labelRepository,
        Context $context
    ) {
        parent::__construct($context);
        $this->labelRepository = $labelRepository;
        $this->labelFactory = $labelFactory;
        $this->dataPersistor = $dataPersistor;
        $this->fileManager = $fileManager;
    }

    public function execute(): ResultInterface
    {
        if ($this->getRequest()->getParams()) {
            $modelLabel = $this->labelFactory->create();
            try {
                $dataLabel = $this->getRequest()->getParams();
                $labelId = $this->getRequest()->getParam('id');
                if ($labelId) {
                    $modelLabel = $this->labelRepository->get($labelId);
                }
                if (isset($dataLabel['image_label'][0]['file'])) {
                    $dataLabel['image_label'] = $dataLabel['image_label'][0]['file'];
                }
                if (isset($dataLabel['rule'])) {
                    $dataLabel['conditions'] = $dataLabel['rule']['conditions'];
                    unset($dataLabel['rule']);
                }
                unset($dataLabel['conditions_serialized']);
                unset($dataLabel['actions_serialized']);
                $modelLabel->loadPost($dataLabel);
                $this->_getSession()->setPageData($dataLabel);
                $this->dataPersistor->set('productlabel_rule', $dataLabel);
                $this->labelRepository->save($modelLabel);
                $this->messageManager->addSuccessMessage(__('You saved the label.'));
                $this->_getSession()->setPageData(false);
                $this->dataPersistor->clear('productlabel_rule');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the label data. Please review the error log.')
                );
                $dataLabelNew = $dataLabel ?? $this->getRequest()->getParams();
                if ($this->fileManager->isExists($dataLabelNew['image_label'][0]['url'])) {
                    $this->fileManager->deleteFile(($dataLabelNew['image_label'][0]['url']));
                }
                $this->_getSession()->setPageData($dataLabelNew);
                $this->dataPersistor->set('productlabel_rule', $dataLabelNew);
                return $this->resultRedirectFactory->create()->setPath('*/*/edit',
                    ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
