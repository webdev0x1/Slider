<?php
namespace Wisepet\Slider\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SliderSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get sliders list.
     *
     * @return SliderInterface[]
     */
    public function getItems();

    /**
     * Set sliders list.
     *
     * @param SliderInterface[] $items Items.
     *
     * @return $this
     */
    public function setItems(array $items);
}
