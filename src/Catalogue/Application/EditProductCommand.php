<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

class EditProductCommand
{
    private string $productIdToEdit;
    private ?string $newProductTitle;
    private ?string $newProductPriceValue;

    public function __construct(string $productIdToEdit, ?string $newProductTitle, ?string $newProductPriceValue)
    {
        $this->productIdToEdit = $productIdToEdit;
        $this->newProductTitle = $newProductTitle;
        $this->newProductPriceValue = $newProductPriceValue;
    }

    public function getProductIdToEdit(): string
    {
        return $this->productIdToEdit;
    }

    public function getNewProductTitle(): ?string
    {
        return $this->newProductTitle;
    }

    public function getNewProductPriceValue(): ?string
    {
        return $this->newProductPriceValue;
    }
}
