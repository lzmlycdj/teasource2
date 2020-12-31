<?php
namespace Codilar\Demo\Block;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class StockLeft extends Template{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var
     */
    private $stockRegistry;


    /**
     * StockLeft constructor.
     * @param Template\Context $context
     * @param Registry $registry
     * @param StockRegistryInterface $stockRegistry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        StockRegistryInterface $stockRegistry,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->stockRegistry=$stockRegistry;
    }

    /**
     * @return false|mixed|string
     */
    public function getData2()
    {
        //3.return it here
        return 10;
    }



    public function getRemainingQty(){
        //1.Fetch the product model
        //2.get the qty from the product model
        $product = $this->getCurrentProduct();
        $stock = $this->stockRegistry->getStockItem($product->getId());
        return $stock->getQty();

    }

    /**
     * @return mixed
     */
    protected  function getCurrentProduct(){
        return $this->registry->registry('product');
    }
}