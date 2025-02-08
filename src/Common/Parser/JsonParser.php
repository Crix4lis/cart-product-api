<?php
declare(strict_types=1);

namespace Task\App\Common\Parser;

use Task\App\Common\Exception\InvalidInputException;

class JsonParser implements Parser
{
    /**
     * @param string $toParse
     *
     * @return array
     *
     * @throws InvalidInputException
     */
    public function parse(string $toParse): array
    {
        $return =  json_decode($toParse, true);

        if ($return === null) {
            throw new InvalidInputException();
        }

        return $return;
    }
}
