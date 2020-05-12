<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Exception;

use Task\App\Common\Exception\RuntimeException;

class TooManyProductsInCartException extends RuntimeException
{
    public function __construct(int $maximum, string $cartId)
    {
        parent::__construct(
            sprintf(
                "Cannot add another product to cart with id %s. Maximum amount of products is %s",
                $cartId,
                (string) $maximum
            )
        );
    }
}
