<?php
namespace Wisepet\Slider\Api\Data;

interface SliderAttributeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Wisepet\Slider\Api\Data\SliderAttributeInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Wisepet\Slider\Api\Data\SliderAttributeInterface[] $items Items.
     *
     * @return $this
     */
    public function setItems(array $items);
}
