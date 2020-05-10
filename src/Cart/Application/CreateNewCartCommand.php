<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

class CreateNewCartCommand
{
    private string $newCartId;
    private string $cartProductReference;

    public function __construct(string $newCartId, string $cartProductReference)
    {
        $this->newCartId = $newCartId;
        $this->cartProductReference = $cartProductReference;
    }

    public function getNewCartId(): string
    {
        return $this->newCartId;
    }

    public function getCartProductReference(): string
    {
        return $this->cartProductReference;
    }
}
