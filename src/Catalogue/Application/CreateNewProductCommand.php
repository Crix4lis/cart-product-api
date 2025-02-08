<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

class CreateNewProductCommand
{
    private string $newProductId;
    private string $title;
    private string $priceAmount;

    public function __construct(string $newProductId, string $title, string $priceAmount)
    {
        $this->newProductId = $newProductId;
        $this->title = $title;
        $this->priceAmount = $priceAmount;
    }

    public function getNewProductId(): string
    {
        return $this->newProductId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriceAmount(): string
    {
        return $this->priceAmount;
    }
}
