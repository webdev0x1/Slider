<?php
namespace Wisepet\Slider\Ui\DataProvider\Slider\Form;

use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Wisepet\Slider\Model\ResourceModel\Slider\CollectionFactory;

class SliderDataProvider extends \Wisepet\ScopedEav\Ui\DataProvider\Entity\Form\EntityDataProvider
{
    /**
     * Constructor.
     *
     * @param string            $name              Source name.
     * @param string            $primaryFieldName  Primary field name.
     * @param string            $requestFieldName  Request field name.
     * @param PoolInterface     $pool              Form modifier pool.
     * @param CollectionFactory $collectionFactory Collection factory.
     * @param array             $meta              Original meta.
     * @param array             $data              Original data.
     */
    // @codingStandardsIgnoreLine Use the factory (MEQP2.Classes.ConstructorOperations.CustomOperationsFound)
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        PoolInterface $pool,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $pool, $meta, $data);

        $this->collection = $collectionFactory->create();
    }
}
