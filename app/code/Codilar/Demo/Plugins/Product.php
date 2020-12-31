<?php

namespace Codilar\Demo\Plugins;


class Product

{
    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param $name
     * @return string
     */
    public function aftergetName(\Magento\Catalog\Model\Product $product, $name)
    {
        $price = $product->getData('price');
        if ($price < 60) {
            $name .= "So cheap";
        } else {
            $name .= "So Bloody expensive";
        }
        return $name;
    }


}