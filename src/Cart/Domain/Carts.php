<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain;

interface Carts
{
    public function getById(string $cartId): Cart;
    public function save(Cart $cart): void;
}
