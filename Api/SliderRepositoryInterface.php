<?php
namespace Wisepet\Slider\Api;

interface SliderRepositoryInterface
{
    /**
     * Save a slider.
     *
     * @param \Wisepet\Slider\Api\Data\SliderInterface $entity Saved entity.
     *
     * @return \\Wisepet\Slider\Api\Data\SliderInterface
     *
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Wisepet\Slider\Api\Data\SliderInterface $entity);

    /**
     * Get slider by id.
     *
     * @param int      $entityId    Entity Id.
     * @param int|null $storeId     Store Id.
     * @param bool     $forceReload Force reload the entity..
     *
     * @return \Wisepet\Slider\Api\Data\SliderInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function get($entityId, $storeId = null, $forceReload = false);

    /**
     * Delete slider.
     *
     * @param \Wisepet\Slider\Api\Data\SliderInterface $entity Deleted entity.
     *
     * @return bool Will returned True if deleted
     *
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Wisepet\Slider\Api\Data\SliderInterface $entity);

    /**
     * Delete slider by id.
     *
     * @param int $entityId Deleted entity id.
     *
     * @return bool Will returned True if deleted
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($entityId);

    /**
     * Get slider list.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search criteria.
     *
     * @return \Wisepet\Slider\Api\Data\SliderSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
