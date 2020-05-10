<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Carts;
use Task\App\Cart\Domain\Product;

class CreateNewCartHandler
{
    private Carts $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    public function handle(CreateNewCartCommand $command): void
    {
        $cart = Cart::createNewCart($command->getNewCartId(), new Product($command->getCartProductReference()));
        $this->carts->save($cart);
    }
}
