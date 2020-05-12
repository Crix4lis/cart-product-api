<?php
declare(strict_types=1);

namespace Task\App\Common\Parser;

interface Parser
{
    public function parse(string $toParse): array;
}
