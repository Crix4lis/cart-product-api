<?php
declare(strict_types=1);

namespace Task\App\Common\Exception;

class NotFoundException extends UIException
{
    public function __construct($message = "Entity not found")
    {
        parent::__construct($message, 404, null);
    }
}
