<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\Repository;

use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Carts;
use Task\App\Cart\Domain\Product;

class DoctrineCarts implements Carts
{
    public function getById(string $cartId): Cart
    {
        // TODO: Implement getById() method.
        return Cart::createNewCart('1', new Product('2'));
    }

    public function save(Cart $cart): void
    {
        // TODO: Implement save() method.
    }
}
