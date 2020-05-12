<?php
declare(strict_types=1);

namespace Task\App\Catalogue\UI\Validator;

use Task\App\Common\Exception\InvalidInputException;

class EditProductValidator extends ProductBaseValidator
{
    /**
     * @param array $input
     *
     * @throws InvalidInputException
     */
    public function validate(array $input): void
    {
        $titleKeyExists = $this->titleKeyExists($input);
        $amountKeyExists = $this->amountKeyExists($input);

        if (false === $titleKeyExists && false === $amountKeyExists) {
            throw new InvalidInputException();
        }

        //if title exists - validate it
        if (true === $titleKeyExists &&
            false === $this->validateIfFieldIsNonEmptyString($input[self::TITLE_KEY])
        ) {
            throw new InvalidInputException();
        }

        //if amount exists - validate it
        if (true === $amountKeyExists
            && false === $this->validateAmount($input[self::AMOUNT_KEY])
        ) {
            throw new InvalidInputException();
        }
    }
}
