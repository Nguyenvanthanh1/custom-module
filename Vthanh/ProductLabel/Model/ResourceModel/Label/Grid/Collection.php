<?php

namespace Vthanh\ProductLabel\Model\ResourceModel\Label\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;

class Collection extends \Vthanh\ProductLabel\Model\ResourceModel\Label\Collection implements SearchResultInterface
{

    public function setItems(array $items = null)
    {
       return null;
    }

    public function getAggregations()
    {
        return null;
    }

    public function setAggregations($aggregations)
    {
        return null;
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        return null;
    }

    public function getTotalCount()
    {
        return null;
    }

    public function setTotalCount($totalCount)
    {
        return null;
    }
}
