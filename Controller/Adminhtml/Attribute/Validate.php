<?php
namespace Wisepet\Slider\Controller\Adminhtml\Attribute;

use Magento\Framework\DataObjectFactory;

class Validate extends \Wisepet\ScopedEav\Controller\Adminhtml\Attribute\Validate
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Wisepet_Slider::attributes_attributes';

    /**
     * Constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context           Context.
     * @param \Wisepet\ScopedEav\Helper\Data                     $entityHelper      Entity helper.
     * @param Builder                                          $attributeBuilder  Attribute builder.
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory JSON response factory.
     * @param DataObjectFactory                                $dataObjectFactory Data object factory.
     */
    // @codingStandardsIgnoreLine Override builder attribute (Generic.CodeAnalysis.UselessOverridingMethod.Found)
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Wisepet\ScopedEav\Helper\Data $entityHelper,
        Builder $attributeBuilder,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        DataObjectFactory $dataObjectFactory
    ) {
        parent::__construct($context, $entityHelper, $attributeBuilder, $resultJsonFactory, $dataObjectFactory);
    }
}
