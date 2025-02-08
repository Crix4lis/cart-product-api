<?php
declare(strict_types=1);

namespace Task\App\Common\Validator;

use Task\App\Common\Exception\InvalidInputException;

interface Validator
{
    /**
     * @param array $input
     *
     * @throws InvalidInputException
     */
    public function validate(array $input): void;
}
