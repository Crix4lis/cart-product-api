<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Carts;
use Task\App\Cart\Domain\Product;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\InvalidInputException;

class CreateNewCartHandler
{
    private Carts $carts;

    public function __construct(Carts $carts)
    {
        $this->carts = $carts;
    }

    /**
     * @param CreateNewCartCommand $command
     *
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function handle(CreateNewCartCommand $command): void
    {
        try {
            $cart = Cart::createNewCart($command->getNewCartId(), new Product($command->getCartProductReference()));
        } catch (\InvalidArgumentException $e) {
            throw new InvalidInputException("Cart id must be in uuid format");
        }

        $this->carts->save($cart);
    }
}
