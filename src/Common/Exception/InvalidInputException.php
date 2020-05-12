<?php
declare(strict_types=1);

namespace Task\App\Common\Exception;

class InvalidInputException extends RuntimeException
{
    public function __construct($message = "Invalid user input")
    {
        parent::__construct($message, 400, null);
    }
}
