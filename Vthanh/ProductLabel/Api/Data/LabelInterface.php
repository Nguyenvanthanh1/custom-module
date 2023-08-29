<?php

namespace Vthanh\ProductLabel\Api\Data;

interface LabelInterface
{
    public function getLabelId(): mixed;

    public function setLabelId($labelId): void;

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function setIsActive(bool $status): void;

    public function getIsActive(): bool;

    public function getFormDate(): string;

    public function setFormDate(string $formDate): void;

    public function getToDate(): string;

    public function setToDate(string $toDate): void;

    public function getImageLabel(): string;

    public function setImageLabel($image): void;

    public function setConditionsSerialized(string $combine);

    public function getConditionsSerialized(): string;

    public function setActionsSerialized(string $combine);

    public function getActionsSerialized(): string;
}
