<?php
declare(strict_types=1);

namespace Task\App\Common\Parser;

class JsonParser implements Parser
{
    public function parse(string $toParse): array
    {
        return json_decode($toParse, true);
    }
}
