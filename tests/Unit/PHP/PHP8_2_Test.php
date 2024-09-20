<?php

namespace Tests\Unit\PHP;

use PHPUnit\Framework\TestCase;
use Tests\Unit\PHP\MyClass;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PHP8_2_Test extends TestCase
{
    use DatabaseTransactions;

    public function test_typed_constants()
    {
        $this->assertEquals(3.14159, MyClass::PI);
        $this->assertIsFloat(MyClass::PI);
        
        $this->assertEquals(100, MyClass::MAX_VALUE);
        $this->assertIsInt(MyClass::MAX_VALUE);
    }

    public function test_readonly_classes()
    {
        $user = new class('John', 30) {
            public function __construct(
                public readonly string $name,
                public readonly int $age
            ) {}
        };

        $this->assertEquals('John', $user->name);
        $this->assertEquals(30, $user->age);

        $this->expectException(\Error::class);
        $user->name = 'Peter';
    }

    public function test_null_false_and_true_as_standalone_types()
    {
        $testNull = function(null $value): string {
            return "It's null!";
        };

        $testFalse = function(false $value): string {
            return "It's false!";
        };

        $testTrue = function(true $value): string {
            return "It's true!";
        };

        $this->assertEquals("It's null!", $testNull(null));
        $this->assertEquals("It's false!", $testFalse(false));
        $this->assertEquals("It's true!", $testTrue(true));

        $this->expectException(\TypeError::class);
        $testNull('not null');
    }
}