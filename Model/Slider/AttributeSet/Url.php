<?php
namespace Wisepet\Slider\Model\Slider\AttributeSet;

use Wisepet\Slider\Model\ResourceModel\Slider\AttributeSet\Url as UrlResourceModel;

class Url
{
    /**
     * @var UrlResourceModel
     */
    private $urlResourceModel;

    /**
     * Url constructor.
     *
     * @param UrlResourceModel $urlResourceModel Attribute set url resource model.
     */
    public function __construct(
        UrlResourceModel $urlResourceModel
    ) {
        $this->urlResourceModel = $urlResourceModel;
    }

    /**
     * Return attribute set id from url key.
     *
     * @param string $urlKey Attribute set url key.
     *
     * @return int
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function checkIdentifier(string $urlKey): int
    {
        return $this->urlResourceModel->checkIdentifier($urlKey);
    }
}
