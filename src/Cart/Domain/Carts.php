<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain;

use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

interface Carts
{
    /**
     * @param string $cartId
     * @return Cart
     *
     * @throws NotFoundException
     */
    public function getById(string $cartId): Cart;
    /**
     * @param Cart $cart
     *
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function save(Cart $cart): void;
}
