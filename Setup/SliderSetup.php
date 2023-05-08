<?php
namespace Wisepet\Slider\Setup;

use Wisepet\ScopedEav\Model\Entity\Attribute\Backend\Image;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Wisepet\Slider\Model\Slider;
use Wisepet\Slider\Model\Slider\Attribute;
use Wisepet\Slider\Model\ResourceModel\Slider\Attribute\Collection;

class SliderSetup extends \Magento\Eav\Setup\EavSetup
{
    /**
     * Installed EAV entities.
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        return [
            'wisepet_slider' => [
                'entity_model'                => Slider::class,
                'attribute_model'             => Attribute::class,
                'table'                       => 'wisepet_slider',
                'attributes'                  => $this->getDefaultAttributes(),
                'additional_attribute_table'  => 'wisepet_slider_eav_attribute',
                'entity_attribute_collection' => Collection::class,
            ],
        ];
    }

    /**
     * List of default attributes.
     *
     * @return array
     */
    private function getDefaultAttributes()
    {
        return [
            'is_active' => [
                'type' => 'int',
                'label' => 'Is Active',
                'input' => 'select',
                'source' => Boolean::class,
                'sort_order' => 2,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General',
            ],
            'position' => [
                'type' => 'varchar',
                'label' => 'position',
                'input' => 'text',
                'required' => false,
                'sort_order' => 3,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General',
            ],
            'content' => [
                'type' => 'text',
                'label' => 'Content',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 4,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'group' => 'General',
            ],
        ];
    }
}
