<?php
namespace Wisepet\Slider\Controller\Adminhtml\Attribute;

use Zend\Validator\RegexFactory;

class Save extends \Wisepet\ScopedEav\Controller\Adminhtml\Attribute\Save
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Wisepet_Slider::attributes_attributes';

    /**
     * Constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context          Context.
     * @param \Wisepet\ScopedEav\Helper\Data        $entityHelper     Entity helper.
     * @param Builder                             $attributeBuilder Attribute builder.
     * @param RegexFactory                        $regexFactory     Regex validator factory.
     */
    // @codingStandardsIgnoreLine Override builder attribute (Generic.CodeAnalysis.UselessOverridingMethod.Found)
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wisepet\ScopedEav\Helper\Data $entityHelper,
        Builder $attributeBuilder,
        RegexFactory $regexFactory
    ) {
        parent::__construct($context, $entityHelper, $attributeBuilder, $regexFactory);
    }
}
