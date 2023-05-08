<?php
namespace Wisepet\Slider\Model\ResourceModel\Slider;

class Collection extends \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'slider_collection';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'slider_collection';

    /**
     * {@inheritDoc}
     */
    public function addIsActiveFilter()
    {
        $this->addAttributeToFilter('is_active', 1);
        $this->_eventManager->dispatch($this->_eventPrefix . '_add_is_active_filter', [$this->_eventObject => $this]);

        return $this;
    }

    /**
     * Init collection and determine table names
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Wisepet\Slider\Model\Slider',
            'Wisepet\Slider\Model\ResourceModel\Slider'
        );
    }
}
