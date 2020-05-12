<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

use Task\App\Cart\Domain\Carts;
use Task\App\Cart\Domain\Exception\TooManyProductsInCartException;
use Task\App\Cart\Domain\Product;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class AddProductToCartHandler
{
    private Carts $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    /**
     * @param AddProductToCartCommand $command
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws TooManyProductsInCartException
     */
    public function handle(AddProductToCartCommand $command): void
    {
        $cart = $this->carts->getById($command->getToCartId());
        $cart->addProduct(new Product($command->getProductReferenceToAdd()));
        $this->carts->save($cart);
    }
}
