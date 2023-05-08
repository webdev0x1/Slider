<?php
namespace Wisepet\Slider\Block\Adminhtml;

use Wisepet\Slider\Api\Data\SliderInterface;

class Entity extends \Wisepet\ScopedEav\Block\Adminhtml\AbstractEntity
{
    /**
     * {@inheritDoc}
     */
    protected function getEntityTypeCode()
    {
        return SliderInterface::ENTITY;
    }
}
