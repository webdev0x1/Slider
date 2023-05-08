<?php
namespace Wisepet\Slider\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Wisepet\Slider\Api\Data\SliderInterface;
use Wisepet\Slider\Model\Slider;
use Wisepet\Slider\Model\Slider\AttributeSet\Url;

class Router implements RouterInterface
{
    /**
     * @var Url
     */
    private $urlSetModel;

    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    private $actionFactory;

    /**
     * @var Slider
     */
    private $slider;

    /**
     * Router constructor.
     *
     * @param \Magento\Framework\App\ActionFactory $actionFactory Action factory.
     * @param Url                                  $urlSetModel   Attribute set url model.
     * @param SliderInterface                $slider  Slider model.
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        Url $urlSetModel,
        SliderInterface $slider
    ) {
        $this->urlSetModel = $urlSetModel;
        $this->actionFactory = $actionFactory;
        $this->slider = $slider;
    }

    /**
     * Match application action by request
     *
     * @param RequestInterface|HttpRequest $request Request.
     *
     * @return ActionInterface|null
     */
    // @codingStandardsIgnoreLine Match function is allow in router (MEQP2.Classes.PublicNonInterfaceMethods.PublicMethodFound)
    public function match(RequestInterface $request)
    {
        $requestPath = trim($request->getPathInfo(), '/');
        $requestPathArray = explode('/', $requestPath);
        if (!$this->isValidPath($requestPathArray) || $request->getAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS)) {
            // Continuing with processing of this URL.
            return null;
        }

        try {
            $entityId = $this->matchSlider($requestPathArray);
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $requestPath)
                ->setModuleName('slider')
                ->setControllerName($this->getControllerName($requestPathArray))
                ->setActionName('view')
                ->setParam('entity_id', $entityId);
        } catch (\Exception $e) {
            // Continuing with processing of this URL.
            return null;
        }

        return $this->actionFactory->create(
            \Magento\Framework\App\Action\Forward::class
        );
    }

    /**
     * Match slider.
     *
     * @param array $requestPathArray Request path array
     *
     * @return int
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    private function matchSlider(array $requestPathArray): int
    {
        $entityId = $sliderSetId = $this->urlSetModel->checkIdentifier(array_shift($requestPathArray));
        if (!empty($requestPathArray) && $sliderSetId) {
            $entityId = $this->slider->checkIdentifier(current($requestPathArray), $entityId);
        }

        return $entityId;
    }

    /**
     * Return controller name.
     *
     * @param array $requestPathArray Request path array.
     *
     * @return string
     */
    private function getControllerName(array $requestPathArray)
    {
        return $this->isSliderSet($requestPathArray) ? 'set' : 'entity';
    }

    /**
     * Return true if we want to see a set of slider.
     *
     * @param array $requestPathArray Request path array.
     *
     * @return bool
     */
    private function isSliderSet(array $requestPathArray): bool
    {
        return count($requestPathArray) == 1;
    }

    /**
     * Return true if current request is allow into this router.
     *
     * @param array $requestPathArray Request path array.
     *
     * @return bool
     */
    private function isValidPath(array $requestPathArray): bool
    {
        return count($requestPathArray) > 0 && count($requestPathArray) <= 2;
    }
}
