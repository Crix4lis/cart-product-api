<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\InvalidInputException;
use Task\App\Common\Exception\NotFoundException;
use Task\App\Common\Price\Price;

class EditProductHandler
{
    private Products $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * @param EditProductCommand $command
     *
     * @throws NotFoundException
     * @throws ConflictException
     * @throws DataLayerException
     * @throws InvalidInputException
     */
    public function handle(EditProductCommand $command): void
    {
        $product = $this->products->getById($command->getProductIdToEdit());

        if (($newTitle = $command->getNewProductTitle()) !== null) {
            try {
                $product->changeProductTitle($newTitle);
            } catch (\InvalidArgumentException $e) {
                throw new InvalidInputException();
            }
        }

        if (($newPriceValue = $command->getNewProductPriceValue()) !== null) {
            try {
                $product->changeProductPrice(Price::createUSD($newPriceValue));
            } catch (\InvalidArgumentException $e) {
                throw new InvalidInputException();
            }
        }

        $this->products->save($product);
    }
}
