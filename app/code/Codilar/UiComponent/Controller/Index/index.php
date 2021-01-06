<?php

namespace Codilar\UiComponent\Controller\Index;

use Magento\Reports\Test\Block\Adminhtml\Viewed\Action;
use Magento\Shipping\Model\Rate\ResultFactory;

class Index extends Action{

    public function excute(){
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}