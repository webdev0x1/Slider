<?php
namespace Wisepet\Slider\Controller\Adminhtml\Set;

use Wisepet\Slider\Api\Data\SliderAttributeInterface;

class Save extends \Wisepet\ScopedEav\Controller\Adminhtml\Set\Save
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Wisepet_Slider::attributes_set';

    /**
     * @var string
     */
    protected $entityTypeCode = SliderAttributeInterface::ENTITY_TYPE_CODE;
}
