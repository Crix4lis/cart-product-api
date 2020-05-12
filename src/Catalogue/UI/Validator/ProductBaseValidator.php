<?php
declare(strict_types=1);

namespace Task\App\Catalogue\UI\Validator;

use Task\App\Common\Validator\Validator;

abstract class ProductBaseValidator implements Validator
{
    public const ID_KEY = 'id';
    public const TITLE_KEY = 'title';
    public const AMOUNT_KEY = 'price_amount';

    protected function idKeyExists($input): bool
    {
        return array_key_exists(self::ID_KEY, $input);
    }

    protected function titleKeyExists($input): bool
    {
        return array_key_exists(self::TITLE_KEY, $input);
    }

    protected function amountKeyExists($input): bool
    {
        return array_key_exists(self::AMOUNT_KEY, $input);
    }

    protected function validateAmount($amountField): bool
    {
        if (false === is_string($amountField) || true === empty($amountField)) {
            return false;
        }

        if ($amountField != (int) $amountField) {
            return false;
        }

        return true;
    }

    protected function validateIfFieldIsNonEmptyString($titleField): bool
    {
        if (false === is_string($titleField) || true === empty($titleField)) {
            return false;
        }

        return true;
    }
}
