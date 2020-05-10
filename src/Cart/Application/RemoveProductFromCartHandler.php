<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

use Task\App\Cart\Domain\Carts;
use Task\App\Cart\Domain\Product;

class RemoveProductFromCartHandler
{
    private Carts $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    public function handle(AddProductToCartCommand $command): void
    {
        $cart = $this->carts->getById($command->getToCartId());
        $cart->removeProduct(new Product($command->getProductReferenceToAdd()));
        $this->carts->save($cart);
    }
}
