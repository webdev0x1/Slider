<?php
namespace Wisepet\Slider\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * Slider EAV setup factory
     *
     * @var SliderSetupFactory
     */
    private $sliderSetupFactory;

    /**
     * Constructor.
     *
     * @param SliderSetupFactory $sliderSetupFactory Slider EAV setup factory.
     */
    public function __construct(SliderSetupFactory $sliderSetupFactory)
    {
        $this->sliderSetupFactory = $sliderSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    // @codingStandardsIgnoreLine Context param not used (Generic.CodeAnalysis.UnusedFunctionParameter.Found)
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var SliderSetup$categorySetup */
        $sliderSetup = $this->sliderSetupFactory->create(['setup' => $setup]);

        $sliderSetup->installEntities();
    }
}
