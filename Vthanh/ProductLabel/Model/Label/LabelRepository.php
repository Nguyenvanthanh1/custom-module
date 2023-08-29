<?php

namespace Vthanh\ProductLabel\Model\Label;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;
use Vthanh\ProductLabel\Api\Data\LabelInterface;
use Vthanh\ProductLabel\Api\LabelRepositoryInterface;
use Vthanh\ProductLabel\Model\LabelFactory;
use Vthanh\ProductLabel\Model\ResourceModel\Label;

/**
 * LabelRepository
 * @package Vthanh\ProductLabel\Model\Label
 */
class LabelRepository implements LabelRepositoryInterface
{

    /**
     * @var
     */
    protected $labels;
    /**
     * @var LabelFactory
     */
    protected $labelFactory;

    /**
     * @var Label
     */
    protected $labelResource;

    /**
     * @param Label $labelResource
     * @param LabelFactory $labelFactory
     */
    public function __construct(
        Label $labelResource,
        LabelFactory $labelFactory
    ) {
        $this->labelFactory = $labelFactory;
        $this->labelResource = $labelResource;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function get($labelId)
    {
        if (!isset($this->labels[$labelId])) {
            $modelLabel = $this->labelFactory->create();
            $modelLabel->load($labelId);
            if (!$modelLabel->getLabelId()) {
                throw new NoSuchEntityException(
                    __('The rule with the "%1" ID wasn\'t found. Verify the ID and try again.', $labelId)
                );
            }
            $this->labels[$labelId] = $modelLabel;
        }
        return $this->labels[$labelId];
    }

    /**
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function save(LabelInterface $model)
    {
        if ($model->getLabelId()) {
            $model = $this->get($model->getLabelId())->setData($model->getData());
        }
        try {
            $this->labelResource->save($model);
            unset($this->labels[$model->getId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The "%1" rule was unable to be saved. Please try again.', $model->getLabelId())
            );
        }
        return $model;
    }
}
