<?php
namespace Wisepet\Slider\Block\Slider;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Wisepet\Slider\Api\Data\SliderInterface;
use Wisepet\Slider\Model\Slider;

class View extends Template implements IdentityInterface
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * @var SliderInterface
     */
    private $slider;

    /**
     * View constructor.
     *
     * @param Template\Context $context      Context.
     * @param Registry         $registry     Registry.
     * @param ImageFactory     $imageFactory Image factory.
     * @param array            $data         Data.
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        ImageFactory $imageFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->imageFactory = $imageFactory;
    }

    /**
     * Return current slider.
     *
     * @return SliderInterface|null
     */
    public function getEntity()
    {
        if (!$this->slider) {
            $this->slider = $this->registry->registry('current_entity');
        }

        return $this->slider;
    }

    /**
     * Return unique ID(s) for each object in system.
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return $this->getEntity()->getIdentities();
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
        if ($this->getEntity()) {
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
        $slider = $this->getEntity();
        $titleBlock = $this->getLayout()->getBlock('page.main.title');
        $pageTitle = 'Sliders';
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
            /** @var Slider $slider */
            $slider = $this->getEntity();
            $homeUrl = $this->_storeManager->getStore()->getBaseUrl();
            $breadcrumbsBlock->addCrumb(
                'home',
                ['label' => __('Home'), 'title' => __('Go to Home Page'), 'link' => $homeUrl]
            );
            $breadcrumbsBlock->addCrumb(
                'set',
                [
                    'label' => $slider->getAttributeSet()->getAttributeSetName(),
                    'title' => $slider->getAttributeSet()->getAttributeSetName(),
                    'link' => $this->_urlBuilder->getDirectUrl($slider->getAttributeSetUrlKey()),
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'slider',
                ['label' => $slider->getId(), 'title' => $slider->getId()]
            );
        }

        return $this;
    }
}
