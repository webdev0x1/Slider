<?php
namespace Wisepet\Slider\Controller\Adminhtml\Entity;

use Wisepet\ScopedEav\Controller\Adminhtml\Entity\BuilderInterface;

class Builder implements BuilderInterface
{
    /**
     * @var \Wisepet\Slider\Api\Data\SliderInterfaceFactory
     */
    private $sliderFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    private $wysiwygConfig;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * Constructor.
     *
     * @param \Wisepet\Slider\Api\Data\SliderInterfaceFactory $sliderFactory Slider factory.
     * @param \Magento\Store\Model\StoreManagerInterface                $storeManager        Store manager.
     * @param \Magento\Framework\Registry                               $registry            Registry.
     * @param \Magento\Cms\Model\Wysiwyg\Config                         $wysiwygConfig       Wysiwyg config.
     */
    public function __construct(
        \Wisepet\Slider\Api\Data\SliderInterfaceFactory $sliderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
    ) {
        $this->sliderFactory = $sliderFactory;
        $this->storeManager        = $storeManager;
        $this->registry            = $registry;
        $this->wysiwygConfig       = $wysiwygConfig;
    }

    /**
     * {@inheritDoc}
     */
    // @codingStandardsIgnoreLine Move class into Model folder (MEQP2.Classes.PublicNonInterfaceMethods.PublicMethodFound)
    public function build(\Magento\Framework\App\RequestInterface $request)
    {
        $entityId = (int) $request->getParam('id');
        $entity   = $this->sliderFactory->create();
        $store    = $this->storeManager->getStore((int) $request->getParam('store', 0));

        $entity->setStoreId($store->getId());
        $entity->setData('_edit_mode', true);

        if ($entityId) {
            $entity->load($entityId);
        }

        $setId = (int) $request->getParam('set');

        if ($setId) {
            $entity->setAttributeSetId($setId);
        }

        $entity->setPrevAttributeSetId((int) $request->getParam('prev_set_id', 0));

        $this->registry->register('entity', $entity);
        $this->registry->register('current_entity', $entity);
        $this->registry->register('current_store', $store);
        $this->wysiwygConfig->setStoreId($request->getParam('store'));

        return $entity;
    }
}
