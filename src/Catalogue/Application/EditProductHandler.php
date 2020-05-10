<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Price\Price;

class EditProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    public function handle(EditProductCommand $command): void
    {
        $product = $this->products->getById($command->getProductIdToEdit());

        if (($newTitle = $command->getNewProductTitle()) !== null) {
            $product->changeProductTitle($newTitle);
        }
        if (($newPriceValue = $command->getNewProductPriceValue()) !== null) {
            $product->changeProductPrice(Price::createUSD($newPriceValue));
        }

        $this->products->save($product);
    }
}
