<?php
declare(strict_types=1);

namespace Task\App\Catalogue\UI\Validator;

class CreateProductValidator extends ProductBaseValidator
{
    public function validate(array $input): bool
    {
        if (false === $this->titleKeyExists($input)) {
            return false;
        }

        if (false === $this->amountKeyExists($input)) {
            return false;
        }

        return $this->validateIfFieldIsNonEmptyString($input[self::TITLE_KEY]) &&
            $this->validateAmount($input[self::AMOUNT_KEY]);
    }
}
