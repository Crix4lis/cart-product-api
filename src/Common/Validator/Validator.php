<?php
declare(strict_types=1);

namespace Task\App\Common\Validator;

interface Validator
{
    public function validate(array $input): bool;
}
