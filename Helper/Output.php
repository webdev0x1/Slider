<?php
namespace Wisepet\Slider\Helper;

use Wisepet\Slider\Api\Data\SliderInterface;
use Wisepet\Slider\Model\Slider;

class Output extends \Magento\Catalog\Helper\Output
{
    public function sliderAttribute(
        SliderInterface $slider,
        string $attributeHtml,
        string $attributeName
    ) {
        $attribute = $this->_eavConfig->getAttribute(Slider::ENTITY, $attributeName);
        if ($attribute &&
            $attribute->getId() &&
            $attribute->getFrontendInput() != 'image' &&
            (!$attribute->getIsHtmlAllowedOnFront() &&
                !$attribute->getIsWysiwygEnabled())
        ) {
            if ($attribute->getFrontendInput() == 'textarea') {
                $attributeHtml = nl2br($attributeHtml);
            }
        }
        if ($attributeHtml !== null
            && $attribute->getIsHtmlAllowedOnFront()
            && $attribute->getIsWysiwygEnabled()
            && $this->isDirectivesExists($attributeHtml)
        ) {
            $attributeHtml = $this->_getTemplateProcessor()->filter($attributeHtml);
        }

        $attributeHtml = $this->process(
            'sliderAttribute',
            $attributeHtml,
            ['product' => $slider, 'attribute' => $attributeName]
        );

        return $attributeHtml;
    }
}
