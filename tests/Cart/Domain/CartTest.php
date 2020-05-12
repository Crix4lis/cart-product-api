<?php
declare(strict_types=1);

namespace Task\Tests\Cart\Domain;

use PHPUnit\Framework\TestCase;
use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Exception\TooManyProductsInCartException;
use Task\App\Cart\Domain\Product;
use Task\App\Cart\Domain\Event\CartEmptied;
use Task\App\Cart\Domain\Event\NewCartCreated;
use Task\App\Cart\Domain\Event\ProductAdded;
use Task\App\Cart\Domain\Event\ProductRemoved;
use Task\Tests\ExampleData\CartBuilder;
use Task\Tests\ExampleData\UuidMotherObject;

class CartTest extends TestCase
{
    public function cartDataProvider(): array
    {
        return [
            'first cart' => ['1', '1'],
            'second cart' => ['2', '1'],
        ];
    }

    /**
     * @dataProvider cartDataProvider
     */
    public function testCreatesCart(string $cartId, string $productId): void
    {
        UuidMotherObject::createOne();
        $expectedEvent = new NewCartCreated($cartId, $productId);

        $cart = Cart::createNewCart($cartId, new Product($productId));
        $events = $cart->getEvents();

        $this->assertEquals($expectedEvent, current($events));
    }

    /**
     * @dataProvider cartDataProvider
     */
    public function testAddsProductToCart(string $cartId, string $productId): void
    {
        $productIdToAdd = '5';
        $expectedEvent = new ProductAdded($cartId, $productIdToAdd);

        $cart = CartBuilder::cart()
            ->withCartId($cartId)
            ->withProductIds($productId)
            ->build();

        $cart->addProduct(new Product($productIdToAdd));
        $events = $cart->getEvents();

        $this->assertEquals($expectedEvent, end($events));
    }

    /**
     * @dataProvider cartDataProvider
     */
    public function testRemovesProductFromCart(string $cartId, string $productId): void
    {
        $expectedEvent = new ProductRemoved($cartId, $productId);

        $cart = CartBuilder::cart()
            ->withCartId($cartId)
            ->withProductIds($productId, '555')
            ->build();

        $cart->removeProduct(new Product($productId));
        $events = $cart->getEvents();

        $this->assertEquals($expectedEvent, end($events));
    }

    /**
     * @dataProvider cartDataProvider
     */
    public function testEmptiesCart(string $cartId, string $productId): void
    {
        $expectedEventProductRemoved = new ProductRemoved($cartId, $productId);
        $expectedEventCartEmptied = new CartEmptied($cartId);

        $cart = CartBuilder::cart()
            ->withCartId($cartId)
            ->withProductIds($productId)
            ->build();

        $cart->removeProduct(new Product($productId));
        $events = $cart->getEvents();

        $this->assertEquals($expectedEventCartEmptied, array_pop($events));
        $this->assertEquals($expectedEventProductRemoved, array_pop($events));
    }

    /**
     * @dataProvider cartDataProvider
     */
    public function testThrowsExceptionWhenTriesToAddFourthProduct(string $cartId, string $productId): void
    {
        $this->expectException(TooManyProductsInCartException::class);
        $cart = CartBuilder::cart()
            ->withCartId($cartId)
            ->withProductIds($productId, '111', '222')
            ->build();

        $cart->addProduct(new Product('444'));
    }
}
