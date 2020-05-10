<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Price\Price;

class CreateNewProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function handle(CreateNewProductCommand $command): void
    {
        $product = Product::createNew(
            $command->getNewProductId(),
            $command->getTitle(),
            Price::createUSD($command->getPriceAmount())
        );
        $this->products->save($product);
    }
}
