<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Repository;

use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Price\Price;

class DoctrineProducts implements Products
{
    public function getById(string $productId): Product
    {
        // TODO: Implement getById() method.
        return Product::createNew('1', '2', Price::createUSD('2'));
    }

    public function save(Product $product): void
    {
        // TODO: Implement save() method.
    }
}
