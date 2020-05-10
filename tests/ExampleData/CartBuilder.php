<?php
declare(strict_types=1);

namespace Task\Tests\ExampleData;

use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Product;

class CartBuilder
{
    private string $cartId;
    private array $productIds;

    public static function cart(): self
    {
        return new self();
    }

    public function build(): Cart
    {
        $cart =  Cart::createNewCart($this->cartId, new Product(array_shift($this->productIds)));
        foreach ($this->productIds as $pId) {
            $cart->addProduct(new Product($pId));
        }

        return $cart;
    }

    public function withCartId(string $withCartId): self
    {
        $this->cartId = $withCartId;

        return $this;
    }

    public function withProductIds(string... $productIds) :self
    {
        $this->productIds = $productIds;

        return $this;
    }

    private function __construct()
    {
        $this->cartId = '1';
        $this->productIds = ['1'];
    }
}
