<?php
declare(strict_types=1);

namespace Task\Tests\Catalogue\Domain;

use PHPUnit\Framework\TestCase;
use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Domain\Event\NewProductCreated;
use Task\App\Catalogue\Domain\Event\ProductPriceChanged;
use Task\App\Catalogue\Domain\Event\ProductRemoved;
use Task\App\Catalogue\Domain\Event\ProductTitleChanged;
use Task\Tests\ExampleData\CatalogueProductBuilder;
use Task\Tests\ExampleData\PriceBuilder;

class ProductTest extends TestCase
{
    public function productsDataProvider(): array
    {
        return [
            'Fallout' => ['1', 'Fallout', '199'],
            'Dont\'t Starve' => ['2', 'Don\'t Starve', '299'],
         ];
    }

    /**
     * @dataProvider productsDataProvider
     */
    public function testCreatesNewProduct(
        string $id,
        string $title,
        string $priceValue
    ): void
    {
        $expectedEvent = new NewProductCreated(
            $id,
            $title,
            $priceValue,
            'USD'
        );

        $price = PriceBuilder::price()
            ->withAmount($priceValue)
            ->build();
        $product = Product::createNew($id, $title, $price);

        $this->assertEquals($expectedEvent, current($product->getEvents()));
    }

    /**
     * @dataProvider productsDataProvider
     */
    public function testChangesProductTitle(
        string $id,
        string $title,
        string $priceValue
    ): void
    {
        $newTitle = 'The New Title';
        $expectedEvent = new ProductTitleChanged($id, $newTitle);

        $product = CatalogueProductBuilder::product()
            ->withId($id)
            ->withTitle($title)
            ->withPriceAmount($priceValue)
            ->build();

        $product->changeProductTitle($newTitle);
        $events = $product->getEvents();

        $this->assertEquals($expectedEvent, end($events));
    }

    /**
     * @dataProvider productsDataProvider
     */
    public function testChangesProductPrice(
        string $id,
        string $title,
        string $priceValue
    ): void
    {
        $newProductPriceAmount = '5000';
        $expectedEvent = new ProductPriceChanged($id, $newProductPriceAmount, 'USD');
        $newPrice = PriceBuilder::price()->withAmount($newProductPriceAmount)->build();

        $product = CatalogueProductBuilder::product()
            ->withId($id)
            ->withTitle($title)
            ->withPriceAmount($priceValue)
            ->build();

        $product->changeProductPrice($newPrice);
        $events = $product->getEvents();

        $this->assertEquals($expectedEvent, end($events));
    }

    /**
     * @dataProvider productsDataProvider
     */
    public function testRemovesProduct(
        string $id,
        string $title,
        string $priceValue
    ): void
    {
        $expectedEvent = new ProductRemoved($id);

        $product = CatalogueProductBuilder::product()
            ->withId($id)
            ->withTitle($title)
            ->withPriceAmount($priceValue)
            ->build();

        $product->remove();
        $events = $product->getEvents();

        $this->assertEquals($expectedEvent, end($events));
    }
}
