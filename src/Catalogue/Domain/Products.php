<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain;

interface Products
{
    public function getById(string $productId): Product;
    public function save(Product $product): void;
}
