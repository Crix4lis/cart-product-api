<?php
declare(strict_types=1);

namespace Task\App\Common\Exception;

class ConflictException extends UIException
{
    public function __construct($message = "Such entity already exists")
    {
        parent::__construct($message, 409, null);
    }
}
