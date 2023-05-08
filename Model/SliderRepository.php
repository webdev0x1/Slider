<?php
namespace Wisepet\Slider\Model;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Store\Model\StoreManagerInterface;
use Wisepet\Slider\Api\SliderRepositoryInterface;
use Wisepet\Slider\Api\Data\SliderInterface;
use Wisepet\Slider\Api\Data\SliderSearchResultsInterface;
use Wisepet\Slider\Api\Data\SliderSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use \Wisepet\Slider\Model\ResourceModel\Slider as SliderResource;
use \Wisepet\Slider\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;

class SliderRepository implements SliderRepositoryInterface
{
    /**
     * @var SliderInterface[]
     */
    protected $instances = [];

    /**
     * @var SliderResource
     */
    private $sliderResource;

    /**
     * @var SliderFactory
     */
    private $sliderFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $extensibleDataObjectConverter;

    /**
     * @var SliderCollectionFactory
     */
    private $sliderCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SliderSearchResultsInterfaceFactory
     */
    private $sliderSearchResultsFactory;

    /**
     * @var JoinProcessorInterface
     */
    private $joinProcessor;

    /**
     * Constructor.
     *
     * @param SliderFactory                       $sliderFactory              Slider factory.
     * @param SliderResource                      $sliderResource             Slider resource model.
     * @param StoreManagerInterface                     $storeManager                     Store manager.
     * @param MetadataPool                              $metadataPool                     Metadata pool.
     * @param ExtensibleDataObjectConverter             $extensibleDataObjectConverter    Converter.
     * @param SliderCollectionFactory             $sliderCollectionFactory    Slider collection
     *                                                                                    factory.
     * @param CollectionProcessorInterface              $collectionProcessor              Search criteria collection
     *                                                                                    processor.
     * @param JoinProcessorInterface                    $joinProcessor                    Extension attriubute join
     *                                                                                    processor.
     * @param SliderSearchResultsInterfaceFactory $sliderSearchResultsFactory Slider search results
     *                                                                                    factory.
     */
    public function __construct(
        SliderFactory $sliderFactory,
        SliderResource $sliderResource,
        StoreManagerInterface $storeManager,
        MetadataPool $metadataPool,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        SliderCollectionFactory $sliderCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $joinProcessor,
        SliderSearchResultsInterfaceFactory $sliderSearchResultsFactory
    ) {
        $this->sliderFactory           = $sliderFactory;
        $this->sliderResource          = $sliderResource;
        $this->storeManager                  = $storeManager;
        $this->metadataPool                  = $metadataPool;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        $this->collectionProcessor           = $collectionProcessor;
        $this->joinProcessor = $joinProcessor;
        $this->sliderSearchResultsFactory = $sliderSearchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Wisepet\Slider\Api\Data\SliderInterface $entity)
    {
        $existingData = $this->extensibleDataObjectConverter->toNestedArray($entity, [], SliderInterface::class);

        if (!isset($existingData['store_id'])) {
            $existingData['store_id'] = (int) $this->storeManager->getStore()->getId();
        }

        $storeId = $existingData['store_id'];

        if ($entity->getId()) {
            $metadata = $this->metadataPool->getMetadata(SliderInterface::class);

            $entity = $this->get($entity->getId(), $storeId);
            $existingData[$metadata->getLinkField()] = $entity->getData($metadata->getLinkField());
        }
        $entity->addData($existingData);

        try {
            $this->sliderResource->save($entity);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save entity: %1', $e->getMessage()), $e);
        }
        unset($this->instances[$entity->getId()]);

        return $this->get($entity->getId(), $storeId);
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function get($entityId, $storeId = null, $forceReload = false)
    {
        $cacheKey = null !== $storeId ? $storeId : 'all';

        if (!isset($this->instances[$entityId][$cacheKey]) || $forceReload === true) {
            $entity = $this->sliderFactory->create();
            if (null !== $storeId) {
                $entity->setStoreId($storeId);
            }
            $entity->load($entityId);
            if (!$entity->getId()) {
                throw NoSuchEntityException::singleField('id', $entityId);
            }
            $this->instances[$entityId][$cacheKey] = $entity;
        }

        return $this->instances[$entityId][$cacheKey];
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Wisepet\Slider\Api\Data\SliderInterface $entity)
    {
        try {
            $entityId = $entity->getId();
            $this->sliderResource->delete($entity);
        } catch (\Exception $e) {
            throw new StateException(__('Cannot delete entity with id %1', $entity->getId()), $e);
        }

        unset($this->instances[$entityId]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($entityId)
    {
        $entity = $this->get($entityId);

        return $this->delete($entity);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Wisepet\Slider\Model\ResourceModel\Slider\Collection $collection */
        $collection = $this->sliderCollectionFactory->create();
        $this->joinProcessor->process($collection);
        $collection->addAttributeToSelect('*');
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var SliderSearchResultsInterface $searchResults */
        $searchResults = $this->sliderSearchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
