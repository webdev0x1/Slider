<?php
namespace Wisepet\Slider\Model\ResourceModel\Slider\Attribute\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Wisepet\Slider\Model\ResourceModel\Slider\Attribute\Collection as AttributeCollection;

class Collection extends AttributeCollection implements SearchResultInterface
{

    /**
     * @var AggregationInterface
     */
    private $aggregations;

    /**
     * {@inheritDoc}
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * {@inheritDoc}
     * Not implemented since useless.
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * {@inheritDoc}
     * Not implemented since useless.
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     * Not implemented since useless.
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
            \Magento\Eav\Model\ResourceModel\Entity\Attribute::class
        );
    }
}
