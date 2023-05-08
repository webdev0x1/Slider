<?php
namespace Wisepet\Slider\Block\Slider;

use Wisepet\Slider\Api\Data\SliderInterface;

class ImageFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $instanceName;

    /**
     * ImageFactory constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager Object manager.
     * @param string                                    $instanceName  Image instance name.
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = Image::class
    ) {
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    /**
     * Return slider image block.
     *
     * @param SliderInterface $entity Current slider.
     *
     * @return Image
     */
    public function create(SliderInterface $entity)
    {
        $data = [
            'data' => [
                'template' => 'Wisepet_Slider::slider/image.phtml',
                'image_url' => $entity->getImageUrl('image'),
                'image_alt' => $entity->getName(),
            ],
        ];

        // @codingStandardsIgnoreLine Factory class (MEQP2.Classes.ObjectManager.ObjectManagerFound)
        return $this->objectManager->create($this->instanceName, $data);
    }
}
