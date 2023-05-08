<?php
namespace Wisepet\Slider\Model\ResourceModel;

use Magento\Eav\Model\Entity\Context;
use Magento\Store\Model\StoreManagerInterface;

class Slider extends \Wisepet\ScopedEav\Model\ResourceModel\AbstractResource
{
    /**
     * @var string
     */
    protected $sliderWebsiteTable;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Slider constructor.
     *
     * @param Context                                                   $context           Context.
     * @param \Magento\Framework\EntityManager\EntityManager            $entityManager     Entity manager.
     * @param \Magento\Eav\Model\Entity\TypeFactory                     $typeFactory       Type factory.
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory            $setFactory        Attribute set factory.
     * @param \Wisepet\ScopedEav\Model\Entity\Attribute\DefaultAttributes $defaultAttributes Default attributes.
     * @param StoreManagerInterface                                     $storeManager      Store manager.
     * @param array                                                     $data              Data.
     */
    public function __construct(
        Context $context,
        \Magento\Framework\EntityManager\EntityManager $entityManager,
        \Magento\Eav\Model\Entity\TypeFactory $typeFactory,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $setFactory,
        \Wisepet\ScopedEav\Model\Entity\Attribute\DefaultAttributes $defaultAttributes,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $entityManager, $typeFactory, $setFactory, $defaultAttributes, $data);
        $this->storeManager = $storeManager;
    }


    /**
     * {@inheritdoc}
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(\Wisepet\Slider\Model\Slider::ENTITY);
        }

        return parent::getEntityType();
    }

    /**
     * Slider website table name getter.
     *
     * @return string
     */
    public function getSliderWebsiteTable()
    {
        if (!$this->sliderWebsiteTable) {
            $this->sliderWebsiteTable = $this->getTable('wisepet_slider_website');
        }

        return $this->sliderWebsiteTable;
    }

    /**
     * Retrieve slider website identifiers
     *
     * @param \Wisepet\Slider\Model\Slider|int $entity Slider.
     *
     * @return array
     */
    public function getWebsiteIds($entity)
    {
        $connection = $this->getConnection();

        $entityId = $entity;

        if ($entity instanceof \Wisepet\Slider\Model\Slider) {
            $entityId = $entity->getEntityId();
        }

        $select = $connection->select()->from(
            $this->getSliderWebsiteTable(),
            'website_id'
        )->where(
            'entity_id = ?',
            (int) $entityId
        );

        return $connection->fetchCol($select);
    }

    /**
     * {@inheritdoc}
     */
    protected function _afterSave(\Magento\Framework\DataObject $entity)
    {
        $this->saveWebsiteIds($entity);

        return parent::_afterSave($entity);
    }

    /**
     * Save entity website relations
     *
     * @param \Wisepet\Slider\Model\Slider $entity Entity.
     *
     * @return $this
     */
    protected function saveWebsiteIds($entity)
    {
        if ($this->storeManager->isSingleStoreMode()) {
            $websiteId = $this->storeManager->getDefaultStoreView()->getWebsiteId();
            $entity->setWebsiteIds([$websiteId]);
        }
        $websiteIds = $entity->getWebsiteIds();

        $entity->setIsChangedWebsites(false);

        $connection = $this->getConnection();

        $oldWebsiteIds = $this->getWebsiteIds($entity);

        $insert = array_diff($websiteIds, $oldWebsiteIds);
        $delete = array_diff($oldWebsiteIds, $websiteIds);

        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $websiteId) {
                $data[] = ['entity_id' => (int) $entity->getEntityId(), 'website_id' => (int) $websiteId];
            }
            $connection->insertMultiple($this->getSliderWebsiteTable(), $data);
        }

        if (!empty($delete)) {
            $websiteIdsForDelete = [];
            foreach ($delete as $websiteId) {
                $websiteIdsForDelete[] = (int) $websiteId;
            }
            $condition = ['entity_id = ?' => (int) $entity->getEntityId(), 'website_id in (?)' => $websiteIdsForDelete];
            $connection->delete($this->getSliderWebsiteTable(), $condition);
        }

        if (!empty($insert) || !empty($delete)) {
            $entity->setIsChangedWebsites(true);
        }

        return $this;
    }
}
