<?php

namespace Vthanh\ProductLabel\Api;

use Vthanh\ProductLabel\Api\Data\LabelInterface;

interface LabelRepositoryInterface
{

    public function get($labelId);

    public function save(LabelInterface $model);

}
