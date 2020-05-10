<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

use Task\App\Catalogue\Domain\Products;

class RemoveProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function handle(RemoveProductCommand $command): void
    {
        $product = $this->products->getById($command->getProductIdToRemove());
        $product->remove();
        $this->products->save($product);
    }
}
