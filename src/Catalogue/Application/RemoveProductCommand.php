<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Application;

class RemoveProductCommand
{
    private string $productIdToRemove;

    public function __construct(string $productIdToRemove)
    {
        $this->productIdToRemove = $productIdToRemove;
    }

    public function getProductIdToRemove(): string
    {
        return $this->productIdToRemove;
    }
}
