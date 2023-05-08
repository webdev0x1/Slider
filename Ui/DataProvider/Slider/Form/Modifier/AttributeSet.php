<?php
namespace Wisepet\Slider\Ui\DataProvider\Slider\Form\Modifier;

use Magento\Ui\Component\Form\Field;
use Wisepet\Slider\Api\Data\SliderInterface;

class AttributeSet extends \Wisepet\ScopedEav\Ui\DataProvider\Entity\Form\Modifier\AbstractModifier
{
    /**
     * @var int
     */
    const ATTRIBUTE_SET_FIELD_ORDER = 30;

    /**
     * @var \Wisepet\Slider\Model\Slider\AttributeSet\Options
     */
    private $attributeSetOptions;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * @var \Wisepet\ScopedEav\Model\Locator\LocatorInterface
     */
    private $locator;

    /**
     * Constructor.
     *
     * @param \Wisepet\ScopedEav\Model\Locator\LocatorInterface             $locator             Entity locator.
     * @param \Magento\Framework\UrlInterface                             $urlBuilder          URL builder.
     * @param \Wisepet\Slider\Model\Slider\AttributeSet\Options $attributeSetOptions Attribute set source model.
     */
    public function __construct(
        \Wisepet\ScopedEav\Model\Locator\LocatorInterface $locator,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Wisepet\Slider\Model\Slider\AttributeSet\Options $attributeSetOptions
    ) {
        $this->attributeSetOptions = $attributeSetOptions;
        $this->urlBuilder          = $urlBuilder;
        $this->locator             = $locator;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        if (($name = $this->getFirstPanelCode($meta)) && $this->locator->getEntity()->getId() == null) {
            $meta[$name]['children']['attribute_set_id']['arguments']['data']['config'] = [
                'component' => 'Magento_Catalog/js/components/attribute-set-select',
                'disableLabel' => true,
                'filterOptions' => true,
                'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                'formElement' => 'select',
                'componentType' => Field::NAME,
                'options' => $this->attributeSetOptions->toOptionArray(),
                'visible' => 1,
                'required' => 1,
                'label' => __('Attribute Set'),
                'source' => $name,
                'dataScope' => 'attribute_set_id',
                'multiple' => false,
                'sortOrder' => $this->getNextAttributeSortOrder($meta, [SliderInterface::IS_ACTIVE], self::ATTRIBUTE_SET_FIELD_ORDER),
            ];
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $entity = $this->locator->getEntity();
        $data[$entity->getId()][self::DATA_SOURCE_DEFAULT]['attribute_set_id'] = $entity->getAttributeSetId();

        return $data;
    }
}
