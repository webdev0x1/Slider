<?php
namespace Wisepet\Slider\Controller\Adminhtml\Entity;

class Index extends \Wisepet\ScopedEav\Controller\Adminhtml\AbstractEntity
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Wisepet_Slider::entity';

    /**
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        return $this->createActionPage(__('Sliders'));
    }
}
