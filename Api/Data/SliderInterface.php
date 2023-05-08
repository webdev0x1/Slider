<?php

namespace Wisepet\Slider\Api\Data;

use Magento\Framework\DataObject\IdentityInterface;

interface SliderInterface extends \Wisepet\ScopedEav\Api\Data\EntityInterface, IdentityInterface
{
    /**
     * Entity code. Can be used as part of method name for entity processing.
     */
    const ENTITY = 'wisepet_slider';

    /**
     * Returns slider url path.
     *
     * @return string
     */
    public function getUrlPath();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Wisepet\Slider\Api\Data\SliderExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Wisepet\Slider\Api\Data\SliderExtensionInterface $extensionAttributes Extension attributes.
     * @return $this
     */
    public function setExtensionAttributes(\Wisepet\Slider\Api\Data\SliderExtensionInterface $extensionAttributes);
}
