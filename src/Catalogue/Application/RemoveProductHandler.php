<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class RemoveProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param RemoveProductCommand $command
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function handle(RemoveProductCommand $command): void
    {
        $product = $this->products->getById($command->getProductIdToRemove());
        $product->remove();
        $this->products->save($product);
    }
}
