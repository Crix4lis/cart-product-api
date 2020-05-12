<?php
declare(strict_types=1);

namespace Task\App\Cart\UI\Validator;

class AddProductValidator extends CartBaseValidator
{
    public function validate(array $input): bool
    {
        if (false === $this->productIdKeyExists($input)) {
            return false;
        }

        return $this->validateIfFieldIsNonEmptyString($input[self::PRODUCT_REFERENCE_KEY]);
    }
}
