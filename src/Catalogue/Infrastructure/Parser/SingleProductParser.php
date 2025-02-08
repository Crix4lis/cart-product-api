<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Parser;

class SingleProductParser
{
    public function parse(array $input): array
    {
        return [
            'id' => $input['id'],
            'title' => $input['title'],
            'price_amount' => $this->amountToHuman($input['price.surrogateAmount']),
            'price_currency' => $input['price.surrogateCurrency'],
        ];
    }

    private function amountToHuman(int $nonHumanAmount): string
    {
        $result = (float) ($nonHumanAmount / 100);
        $result = (string) $result;
        $exploded = explode('.', $result);

        if (false === array_key_exists(1, $exploded)) {
            return $result . '.00';
        }

        if (strlen($exploded[1]) === 1) {
            return $result . '0';
        }

        return $result;
    }
}
