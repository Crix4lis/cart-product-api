<?php
declare(strict_types=1);

namespace Task\Tests\ExampleData;

use Task\App\Catalogue\Domain\Product;
use Task\App\Common\Price\Price;

class CatalogueProductBuilder
{
    private string $id;
    private string $title;
    private string $priceAmount;

    public static function product(): CatalogueProductBuilder
    {
        return new self();
    }

    public function withId(string $id): CatalogueProductBuilder
    {
        $this->id = $id;

        return $this;
    }

    public function withTitle(string $withTitle): CatalogueProductBuilder
    {
        $this->title = $withTitle;

        return $this;
    }

    public function withPriceAmount(string $withPriceAmount): CatalogueProductBuilder
    {
        $this->priceAmount = $withPriceAmount;

        return $this;
    }

    public function build(): Product
    {
        return Product::createNew(
            $this->id,
            $this->title,
            PriceBuilder::price()->withAmount($this->priceAmount)->build()
        );
    }

    private function __construct()
    {
        $this->id = '1';
        $this->title = 'The Title';
        $this->priceAmount = '299';
    }
}
