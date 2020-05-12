<?php
declare(strict_types=1);

namespace Task\App\Common\Generator;

use Ramsey\Uuid\Uuid;

class RandomUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return (Uuid::uuid4())->toString();
    }
}
