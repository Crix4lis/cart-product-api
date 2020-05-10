<?php
declare(strict_types=1);

namespace Task\Tests\ExampleData;

use Task\App\Common\Price\Price;

class PriceBuilder
{
    private string $amount;

    public static function price(): PriceBuilder
    {
        return new self();
    }

    public function withAmount(string $withAmount): self
    {
        $this->amount = $withAmount;

        return $this;
    }

    public function build(): Price
    {
        return Price::createUSD($this->amount);
    }

    private function __construct()
    {
        $this->amount = '1.00';
    }
}
