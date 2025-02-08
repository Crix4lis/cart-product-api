<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain;

use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

interface Products
{
    /**
     * @param string $productId
     * @return Product
     *
     * @throws NotFoundException
     */
    public function getById(string $productId): Product;

    /**
     * @param Product $product
     *
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function save(Product $product): void;
}
