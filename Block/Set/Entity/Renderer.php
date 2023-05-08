<?php
namespace Wisepet\Slider\Block\Set\Entity;

use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\View\Element\Template;
use Wisepet\Slider\Api\Data\SliderInterface;
use Wisepet\Slider\Block\Slider\ImageFactory;

class Renderer extends Template
{
    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * Renderer constructor.
     *
     * @param Template\Context $context      Context.
     * @param ImageFactory     $imageFactory slider image block factory.
     * @param array            $data         Block data.
     */
    public function __construct(
        Template\Context $context,
        ImageFactory $imageFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->imageFactory = $imageFactory;
    }

    /**
     * Return slider image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->imageFactory->create($this->getEntity())->toHtml();
    }

    /**
     * Return entity url.
     *
     * @return string
     */
    public function getEntityUrl()
    {
        return $this->_urlBuilder->getDirectUrl($this->getEntity()->getUrlPath());
    }
}
