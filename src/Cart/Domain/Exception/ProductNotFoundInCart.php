<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Exception;

use Task\App\Common\Exception\NotFoundException;

class ProductNotFoundInCart extends NotFoundException
{
    private string $productId;
    private string $cartId;

    public function __construct(
        string $cartId,
        string $productId,
        $message = ""
    )
    {
        if ($message === "") {
            $message = sprintf(
                "Product with id %s not found in cart %s",
                $productId,
                $cartId
            );
        }
        parent::__construct($message);
        $this->productId = $productId;
        $this->cartId = $cartId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }
}
