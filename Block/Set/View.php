<?php
namespace Wisepet\Slider\Block\Set;

use Magento\Eav\Api\Data\AttributeSetInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\RendererList;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Wisepet\Slider\Api\SliderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Wisepet\Slider\Api\Data\SliderInterface;
use Wisepet\Slider\Block\Html\Pager;
use Wisepet\Slider\Model\Slider;

class View extends Template implements IdentityInterface
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $_sortOrderBuilder;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @var SliderRepositoryInterface
     */
    private $sliderRepository;

    /**
     * @var \Wisepet\Slider\Api\Data\SliderInterface[]|null
     */
    private $entities;

    /**
     * View constructor.
     *
     * @param Template\Context                $context                      Context.
     * @param Registry                        $registry                     Registry.
     * @param SliderRepositoryInterface $sliderRepository       Slider repository.
     * @param SearchCriteriaBuilderFactory    $searchCriteriaBuilderFactory Search criteria builder factory.
     * @param array                           $data                         Block data.
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        SliderRepositoryInterface $sliderRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
	\Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
	$this->_sortOrderBuilder = $sortOrderBuilder;
        $this->sliderRepository = $sliderRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
    }

    /**
     * Return sliders.
     *
     * @return \Wisepet\Slider\Api\Data\SliderInterface[]
     */
    public function getEntities()
    {
        if (!$this->entities) {
	    $sortOrder = $this->_sortOrderBuilder->setField('position')->create();
	    
            $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
            // $searchCriteriaBuilder->addFilter(
            //     'attribute_set_id',
            //     $this->getAttributeSet()->getAttributeSetId()
            // );
            $searchCriteria = $searchCriteriaBuilder->addFilter(
                'is_active',
                true
            )->create();
            //$this->getPager()->addCriteria($searchCriteriaBuilder);
            $searchResult = $this->sliderRepository->getList($searchCriteria);
            //$this->getPager()->setSearchResult($searchResult);
//	    echo gettype($searchResult->getItems());die();
            $items = $searchResult->getItems();//->getSelect()->orderRand();
	    shuffle($items);
            $this->entities = $items; //$searchResult->getItems();
        }

        return $this->entities;
    }

    /**
     * Return slider html.
     *
     * @param SliderInterface $entity Slider.
     *
     * @return string
     */
    public function getEntityHtml(SliderInterface $entity)
    {
        return $this->getEntityRenderer($this->getAttributeSet()->getAttributeSetName())->setEntity($entity)->toHtml();
    }

    /**
     * Return current attribute set.
     *
     * @return AttributeSetInterface|null
     */
    public function getAttributeSet()
    {
        return $this->registry->registry('current_attribute_set');
    }

    /**
     * Return block identities.
     *
     * @return array|string[]
     */
    public function getIdentities()
    {
        $identities = [];
        foreach ($this->getEntities() as $entity) {
            $identities = array_merge($identities, $entity->getIdentities());
        }
       // $identities[] = Slider::CACHE_CUSTOM_ENTITY_SET_TAG.'_'.$this->getAttributeSet()->getAttributeSetId();

        return $identities;
    }

    /**
     * Return pager.
     *
     * @return Pager
     */
    public function getPager()
    {
        return $this->getChildBlock('pager');
    }

    /**
     * Prepare layout: add title and breadcrumbs.
     *
     * @return $this|Template
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getAttributeSet()) {
            $this->setPageTitle()
                ->setBreadcrumbs();
        }

        return $this;
    }

    /**
     * Set the current page title.
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function setPageTitle()
    {
        $attributeSet = $this->getAttributeSet();
        $titleBlock = $this->getLayout()->getBlock('page.main.title');
        $pageTitle = $attributeSet->getAttributeSetName();
        if ($titleBlock) {
            $titleBlock->setPageTitle($pageTitle);
        }
        $this->pageConfig->getTitle()->set(__($pageTitle));

        return $this;
    }

    /**
     * Build breadcrumbs for the current page.
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function setBreadcrumbs()
    {
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
        if ($breadcrumbsBlock) {
            $attributeSet = $this->getAttributeSet();
            $homeUrl = $this->_storeManager->getStore()->getBaseUrl();
            $breadcrumbsBlock->addCrumb(
                'home',
                ['label' => __('Home'), 'title' => __('Go to Home Page'), 'link' => $homeUrl]
            );
            $breadcrumbsBlock->addCrumb(
                'attribute_set',
                ['label' => $attributeSet->getAttributeSetName(), 'title' => $attributeSet->getAttributeSetName()]
            );
        }

        return $this;
    }

    /**
     * Return slider renderer.
     *
     * @param string|null $attributeSetCode Attribute set code.
     *
     * @return bool|\Magento\Framework\View\Element\AbstractBlock
     */
    private function getEntityRenderer($attributeSetCode = null)
    {
        if ($attributeSetCode === null) {
            $attributeSetCode = 'default';
        }
        /** @var RendererList $rendererList */
        $rendererList = $this->getChildBlock('renderer.list');

        return $rendererList->getRenderer($attributeSetCode, 'default');
    }
}
