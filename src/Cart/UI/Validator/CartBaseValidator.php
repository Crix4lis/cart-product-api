<?php
declare(strict_types=1);

namespace Task\App\Cart\UI\Validator;

use Task\App\Common\Validator\Validator;

abstract class CartBaseValidator implements Validator
{
    public const PRODUCT_REFERENCE_KEY = 'product_id';

    protected function productIdKeyExists($input): bool
    {
        return array_key_exists(self::PRODUCT_REFERENCE_KEY, $input);
    }

    protected function validateIfFieldIsNonEmptyString($titleField): bool
    {
        if (false === is_string($titleField) || true === empty($titleField)) {
            return false;
        }

        return true;
    }
}
