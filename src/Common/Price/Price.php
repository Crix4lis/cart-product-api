<?php
declare(strict_types=1);

namespace Task\App\Common\Price;

use Money\Money;

class Price
{
    private string $surrogateAmount;
    private string $surrogateCurrency;
    private Money $price;

    public static function createUSD(string $amount): Price
    {
        return new self(Money::USD($amount));
    }

    public function add(Price $priceToAdd): Price
    {
        return new self($this->price->add($priceToAdd->price));
    }

    public function getCurrency(): string
    {
        return (string) $this->price->getCurrency();
    }

    public function getAmount(): string
    {
        return $this->price->getAmount();
    }

    private function __construct(Money $price)
    {
        $this->price = $price;
        $this->surrogateAmount = $price->getAmount();
        $this->surrogateCurrency = (string) $price->getCurrency();
    }
}
