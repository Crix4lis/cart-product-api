<?php
declare(strict_types=1);

namespace Task\App\Common\Price;

use Money\Currency;
use Money\Money;

class Price
{
    private string $surrogateAmount;
    private string $surrogateCurrency;
    private ?Money $price;

    public static function createUSD(string $amount): Price
    {
        return new self(Money::USD($amount));
    }

    public function add(Price $priceToAdd): Price
    {
        $this->createMoneyInstance();

        return new self($this->price->add($priceToAdd->price));
    }

    public function getCurrency(): string
    {
        $this->createMoneyInstance();

        return (string) $this->price->getCurrency();
    }

    public function getAmount(): string
    {
        $this->createMoneyInstance();

        return $this->price->getAmount();
    }

    private function __construct(Money $price)
    {
        $this->price = $price;
        $this->surrogateAmount = $price->getAmount();
        $this->surrogateCurrency = (string) $price->getCurrency();
    }

    private function createMoneyInstance(): void
    {
        if ($this->price === null) {
            $this->price = new Money($this->surrogateAmount, new Currency($this->surrogateCurrency));
        }
    }
}
