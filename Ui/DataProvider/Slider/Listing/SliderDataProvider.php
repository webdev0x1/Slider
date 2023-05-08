<?php
namespace Wisepet\Slider\Ui\DataProvider\Slider\Listing;

use \Wisepet\Slider\Model\ResourceModel\Slider\CollectionFactory;

class SliderDataProvider extends \Wisepet\ScopedEav\Ui\DataProvider\Entity\Listing\EntityDataProvider
{
    /**
     * Constructor.
     *
     * @param string                                                    $name                Name.
     * @param string                                                    $primaryFieldName    Primary field name.
     * @param string                                                    $requestFieldName    Request field name.
     * @param CollectionFactory                                         $collectionFactory   Collection factory.
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]  $addFieldStrategies  Field add stategies.
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies Filter strategies.
     * @param array                                                     $meta                Meta.
     * @param array                                                     $data                Data.
     */
    // @codingStandardsIgnoreLine Use the factory (MEQP2.Classes.ConstructorOperations.CustomOperationsFound)
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Wisepet\Slider\Model\ResourceModel\Slider\CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $addFieldStrategies, $addFilterStrategies, $meta, $data);

        $this->collection = $collectionFactory->create();
    }
}
