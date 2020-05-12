<?php
declare(strict_types=1);

namespace Task\App\Catalogue\UI\Validator;

class EditProductValidator extends ProductBaseValidator
{
    public function validate(array $input): bool
    {
        $titleKeyGone = false;
        $amountKeyGone = false;

        if (false === $this->idKeyExists($input)) {
            return false;
        }

        if (false === $this->validateIfFieldIsNonEmptyString($input[self::ID_KEY])) {
            return false;
        }

        if ($titleKeyGone = false === $this->titleKeyExists($input) &&
            $amountKeyGone = false === $this->amountKeyExists($input)
        ) {
            return false;
        }

        //if title gone, validate amount
        if (true === $titleKeyGone) {
            return $this->validateIfFieldIsNonEmptyString($input[self::TITLE_KEY]);
        }

        //if amount gone, validate title
        if (true === $amountKeyGone ) {
            return $this->validateAmount($input[self::AMOUNT_KEY]);
        }

        // if title and amount not gone, validate both
        return $this->validateIfFieldIsNonEmptyString($input[self::TITLE_KEY]) &&
            $this->validateAmount($input[self::AMOUNT_KEY]);
    }
}
