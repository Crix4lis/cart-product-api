<?php
declare(strict_types=1);

namespace Task\App\Cart\UI\Validator;

use Task\App\Common\Exception\InvalidInputException;

class CreateCartValidator extends CartBaseValidator
{
    /**
     * @param array $input
     *
     * @throws InvalidInputException
     */
    public function validate(array $input): void
    {
        if (false === $this->productIdKeyExists($input)) {
            throw new InvalidInputException();
        }

        if (false === $this->validateIfFieldIsNonEmptyString($input[self::PRODUCT_REFERENCE_KEY])) {
            throw new InvalidInputException();
        }
    }
}
