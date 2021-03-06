<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogSearch\Model\Layer\Filter;

/**
 * Test class for \Magento\CatalogSearch\Model\Layer\Filter\Decimal.
 *
 * @magentoDataFixture Magento/Catalog/Model/Layer/Filter/_files/attribute_weight_filterable.php
 * @magentoDataFixture Magento/Catalog/_files/categories.php
 * @magentoDataFixture Magento/Catalog/Model/Layer/Filter/Price/_files/products_base.php
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class DecimalTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\CatalogSearch\Model\Layer\Filter\Decimal
     */
    protected $_model;

    protected function setUp()
    {
        $category = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
            ->create(
                \Magento\Catalog\Model\Category::class
            );
        $category->load(4);

        $layer = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
            ->create(
                \Magento\Catalog\Model\Layer\Category::class,
                [
                    'data' => ['current_category' => $category]
                ]
            );

        /** @var $attribute \Magento\Catalog\Model\Entity\Attribute */
        $attribute = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
            ->create(
                \Magento\Catalog\Model\Entity\Attribute::class
            );
        $attribute->loadByCode('catalog_product', 'weight');

        $this->_model = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
            ->create(\Magento\CatalogSearch\Model\Layer\Filter\Decimal::class, ['layer' => $layer]);
        $this->_model->setAttributeModel($attribute);
    }
    
    /**
     * Test the filter label is correct
     */
    public function testApplyFilterLabel()
    {
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        /** @var $request \Magento\TestFramework\Request */
        $request = $objectManager->get(\Magento\TestFramework\Request::class);
        $request->setParam('weight', '10-20');
        $this->_model->apply($request);

        $filters = $this->_model->getLayer()->getState()->getFilters();
        $this->assertArrayHasKey(0, $filters);
        $this->assertEquals(
            '<span class="price">$10.00</span> - <span class="price">$19.99</span>',
            (string)$filters[0]->getLabel()
        );
    }

    /**
     * Test the filter label is correct when there is empty To value
     */
    public function testApplyFilterLabelWithEmptyToValue()
    {
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        /** @var $request \Magento\TestFramework\Request */
        $request = $objectManager->get(\Magento\TestFramework\Request::class);
        $request->setParam('weight', '10-');
        $this->_model->apply($request);

        $filters = $this->_model->getLayer()->getState()->getFilters();
        $this->assertArrayHasKey(0, $filters);
        $this->assertEquals(
            '<span class="price">$10.00</span> and above',
            (string)$filters[0]->getLabel()
        );
    }

    public function testApplyNothing()
    {
        $this->assertEmpty($this->_model->getData('range'));
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        /** @var $request \Magento\TestFramework\Request */
        $request = $objectManager->get(\Magento\TestFramework\Request::class);
        $this->_model->apply($request);

        $this->assertEmpty($this->_model->getData('range'));
    }

    public function testApplyInvalid()
    {
        $this->assertEmpty($this->_model->getData('range'));
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        /** @var $request \Magento\TestFramework\Request */
        $request = $objectManager->get(\Magento\TestFramework\Request::class);
        $request->setParam('decimal', 'non-decimal');
        $this->_model->apply($request);

        $this->assertEmpty($this->_model->getData('range'));
    }

    /**
     * @return Decimal
     */
    public function testApply()
    {
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        /** @var $request \Magento\TestFramework\Request */
        $request = $objectManager->get(\Magento\TestFramework\Request::class);
        $request->setParam('decimal', '1-100');
        $this->_model->apply($request);

        return $this->_model;
    }
}
