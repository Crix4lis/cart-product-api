<?php
declare(strict_types=1);

namespace Task\Tests\ExampleData;

class UuidMotherObject
{
    public static function createFirst(): string
    {
        return '8ed464b3-7bb6-44f4-bd45-b163652896f8';
    }

    public static function createSecond(): string
    {
        return '8ed464b3-7bb6-44f4-bd45-b163652896f2';
    }
    public static function createThird(): string
    {
        return '8ed464b3-7bb6-44f4-bd45-b163652896f3';
    }
}
