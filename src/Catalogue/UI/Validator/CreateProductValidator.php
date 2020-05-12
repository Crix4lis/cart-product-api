<?php
declare(strict_types=1);

namespace Task\App\Catalogue\UI\Validator;

use Task\App\Common\Exception\InvalidInputException;

class CreateProductValidator extends ProductBaseValidator
{
    /**
     * @param array $input
     *
     * @throws InvalidInputException
     */
    public function validate(array $input): void
    {
        if (false === $this->titleKeyExists($input)) {
            throw new InvalidInputException(sprintf(
                "Key %s and %s must both be provided",
                self::TITLE_KEY,
                self::AMOUNT_KEY
            ));
        }

        if (false === $this->amountKeyExists($input)) {
            throw new InvalidInputException(sprintf(
                "Key %s and %s must both be provided",
                self::TITLE_KEY,
                self::AMOUNT_KEY
            ));
        }

        if(false === (
            $this->validateIfFieldIsNonEmptyString($input[self::TITLE_KEY]) &&
            $this->validateAmount($input[self::AMOUNT_KEY]))
        ) {
            throw new InvalidInputException(
                "Product title must not be empty string and ".
                "Product price amount must be provided as integerish string of cents. Ex.: \"500\" meaning 5.00$"
            );
        }
    }
}
