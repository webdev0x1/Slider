<?php
namespace Wisepet\Slider\Controller\Adminhtml\Attribute;

use Wisepet\Slider\Api\SliderAttributeRepositoryInterface;
use Wisepet\Slider\Api\Data\SliderAttributeInterface;
use Wisepet\Slider\Api\Data\SliderAttributeInterfaceFactory;

class Builder extends \Wisepet\ScopedEav\Controller\Adminhtml\Attribute\AbstractBuilder
{
    /**
     * @var SliderAttributeInterfaceFactory
     */
    private $attributeFactory;

    /**
     * @var SliderAttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * Constructor.
     *
     * @param \Magento\Framework\Registry              $registry            Registry.
     * @param \Magento\Eav\Model\Config                $eavConfig           EAV config.
     * @param SliderAttributeInterfaceFactory    $attributeFactory    Attribute factory.
     * @param SliderAttributeRepositoryInterface $attributeRepository Attribute repository.
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Eav\Model\Config $eavConfig,
        SliderAttributeInterfaceFactory $attributeFactory,
        SliderAttributeRepositoryInterface $attributeRepository
    ) {
        parent::__construct($registry, $eavConfig);

        $this->attributeFactory    = $attributeFactory;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeFactory()
    {
        return $this->attributeFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeRepository()
    {
        return $this->attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityTypeCode()
    {
        return SliderAttributeInterface::ENTITY_TYPE_CODE;
    }
}
