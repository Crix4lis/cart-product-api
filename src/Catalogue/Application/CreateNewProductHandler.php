<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Exception\NotFoundException;
use Task\App\Common\Price\Price;

class CreateNewProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param CreateNewProductCommand $command
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function handle(CreateNewProductCommand $command): void
    {
        try {
            $product = Product::createNew(
                $command->getNewProductId(),
                $command->getTitle(),
                Price::createUSD($command->getPriceAmount())
            );
        } catch (\InvalidArgumentException $e) {
            throw new InvalidInputException("Amount or product id is invalid");
        }

        $this->products->save($product);
    }
}
