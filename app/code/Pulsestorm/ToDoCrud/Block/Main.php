<?php
namespace Pulsestorm\ToDoCrud\Block;

/**
 * Class Main
 */
class Main extends \Magento\Framework\View\Element\Template
{
    protected $toDoFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Pulsestorm\ToDoCrud\Model\TodoItemFactory $toDoFactory
    )
    {
        $this->toDoFactory = $toDoFactory;
        parent::__construct($context);
    }
    function _prepareLayout(){
        $todo = $this->toDoFactory->create();
        $todo->setData('item_text','Finish my Magento article')
            ->save();
        var_dump('Done');
        exit;
//        $model = Mage::getModel('pulsestorm_todocrud/todoitem')
//            ->setItemText('Finish my Magento Article')
//            ->save();
    }
}
