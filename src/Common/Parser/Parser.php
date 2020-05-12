<?php
declare(strict_types=1);

namespace Task\App\Common\Parser;

use Task\App\Common\Exception\InvalidInputException;

interface Parser
{
    /**
     * @param string $toParse
     *
     * @return array
     *
     * @throws InvalidInputException
     */
    public function parse(string $toParse): array;
}
