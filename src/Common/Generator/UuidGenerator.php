<?php
declare(strict_types=1);

namespace Task\App\Common\Generator;

interface UuidGenerator
{
    public function generate(): string;
}
