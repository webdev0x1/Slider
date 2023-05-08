<?php

namespace Wisepet\Slider\Api\Data;

interface SliderAttributeInterface extends \Wisepet\ScopedEav\Api\Data\AttributeInterface
{
    /**
     * Entity code. Can be used as part of method name for entity processing.
     */
    const ENTITY_TYPE_CODE = 'wisepet_slider';
}
