<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

use Task\App\Cart\Domain\Carts;
use Task\App\Cart\Domain\Product;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class RemoveProductFromCartHandler
{
    private Carts $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    /**
     * @param RemoveProductFromCartCommand $command
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function handle(RemoveProductFromCartCommand $command): void
    {
        $cart = $this->carts->getById($command->getToCartId());
        $cart->removeProduct(new Product($command->getProductReferenceToRemove()));
        $this->carts->save($cart);
    }
}
