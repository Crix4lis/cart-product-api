<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

class AddProductToCartCommand
{
    private string $toCartId;
    private string $productReferenceToAdd;

    public function __construct(string $toCartId, string $productReferenceToAdd)
    {
        $this->toCartId = $toCartId;
        $this->productReferenceToAdd = $productReferenceToAdd;
    }

    public function getToCartId(): string
    {
        return $this->toCartId;
    }

    public function getProductReferenceToAdd(): string
    {
        return $this->productReferenceToAdd;
    }
}
