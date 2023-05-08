<?php
namespace Wisepet\Slider\Api;

interface SliderAttributeRepositoryInterface extends \Magento\Framework\Api\MetadataServiceInterface
{
    /**
     * Retrieve specific attribute.
     *
     * @param string $attributeCode Attribute code.
     *
     * @return \Wisepet\Slider\Api\Data\SliderAttributeInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($attributeCode);

    /**
     * Save attribute data.
     *
     * @param \Wisepet\Slider\Api\Data\SliderAttributeInterface $attribute Attribute.
     *
     * @return \Wisepet\Slider\Api\Data\SliderAttributeInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function save(\Wisepet\Slider\Api\Data\SliderAttributeInterface $attribute);

    /**
     * Delete Attribute.
     *
     * @param \Wisepet\Slider\Api\Data\SliderAttributeInterface $attribute Attribute.
     *
     * @return bool True if the entity was deleted (always true)
     *
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete(\Wisepet\Slider\Api\Data\SliderAttributeInterface $attribute);

    /**
     * Delete Attribute by id
     *
     * @param string $attributeCode Attribute code.
     *
     * @return bool
     *
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($attributeCode);

    /**
     * Retrieve all attributes for entity type.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search criteria.
     *
     * @return \Wisepet\Slider\Api\Data\SliderAttributeSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
