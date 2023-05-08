<?php
namespace Wisepet\Slider\Model\Slider\AttributeSet;

use Wisepet\Slider\Api\Data\SliderInterface;

class Options extends \Magento\Catalog\Model\Product\AttributeSet\Options
{
    /**
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     * Constructor.
     *
     * @param \Magento\Eav\Model\Config $eavConfig EAV Config.
     */
    public function __construct(\Magento\Eav\Model\Config $eavConfig)
    {
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function toOptionArray()
    {
        $entityType             = $this->eavConfig->getEntityType(SliderInterface::ENTITY);
        $attributeSetCollection = $entityType->getAttributeSetCollection();

        return $attributeSetCollection->toOptionArray();
    }
}
