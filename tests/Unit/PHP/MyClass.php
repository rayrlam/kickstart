<?php

namespace Tests\Unit\PHP;

class MyClass {
    public const float PI = 3.14159;
    public const int MAX_VALUE = 100;

    public const DB_HOST = 'localhost';
    public const DB_USER = 'root';

    public function greet(string $name): string
    {
        return "Hello, $name!";
    }

    public function processInput(string|int $input): string|int
    {
        return $input;
    }

    public function numberToWord(int $number): string
    {
        return match ($number) {
            1 => 'one',
            2 => 'two',
            3, 4, 5 => 'three four five',
            default => 'any',
        };
    }
}