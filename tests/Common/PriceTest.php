<?php
declare(strict_types=1);

namespace Task\Test\Common;

use PHPUnit\Framework\TestCase;
use Task\App\Common\Price\Price;

class PriceTest extends TestCase
{
    public function validAmountDataProvider(): array
    {
        return [
            '20.00 USD' => ['2000', '2000'],
            '2.00 USD' => ['200', '200'],
            '0.20 USD' => ['20', '20'],
            '0 USD' => ['0', '0'],
            '- 2.00 USD' => ['-2', '-2']
        ];
    }

    public function validAdditionDataProvider(): array
    {
        return [
            '(20.00 + 20.00) USD' => ['2000', '2000', '4000'],
            '(2.00 + (- 2.00)) USD' => ['200', '-200', '0'],
            '(0 + 0.1) USD' => ['0', '100', '100'],
            '(0 - 0.1) USD' => ['0', '-100', '-100'],
        ];
    }

    /**
     * @dataProvider validAmountDataProvider
     */
    public function testCreatesUsd(string $from, string $expected): void
    {
        $price = Price::createUSD($from);
        $this->assertEquals('USD', $price->getCurrency());
        $this->assertEquals($expected, $price->getAmount());
    }

    /**
     * @dataProvider validAdditionDataProvider
     */
    public function testAddsPrices(string $first, string $last, string $expected): void
    {
        $price1 = Price::createUSD($first);
        $price2 = Price::createUSD($last);
        $this->assertEquals($expected, ($price1->add($price2))->getAmount());
    }
}
