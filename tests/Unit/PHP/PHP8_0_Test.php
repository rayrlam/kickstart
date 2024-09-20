<?php

namespace Tests\Unit\PHP;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TypeError;
use Tests\Unit\PHP\MyClass;

class PHP8_0_Test extends TestCase
{
    use DatabaseTransactions;

    public function test_named_arguments()
    {
        $this->assertEquals('Hello, World!',  (new MyClass())->greet(name: 'World'));
    }

    public function test_union_types()
    {
        $this->assertIsString( (new MyClass())->processInput('test'));
        $this->assertIsInt( (new MyClass())->processInput(42));
        $this->expectException(TypeError::class);
        // Should throw TypeError
        (new MyClass())->processInput([]); 
    }

    public function testMatchExpression()
    {
        $this->assertEquals('one', (new MyClass())->numberToWord(1));
        $this->assertEquals('two', (new MyClass())->numberToWord(2));
        $this->assertEquals('three four five', (new MyClass())->numberToWord(3));
        $this->assertEquals('any', (new MyClass())->numberToWord(10));
    }

    public function test_null_safe_operator()
    {
        $user = null;
        $this->assertNull($user?->name);
    
        $user = new \stdClass();
        $user->name = 'John';
        $this->assertEquals('John', $user?->name);
    }

    public function test_constructor_property_promotion()
    {
        $person = new class('John', 30) {
            public function __construct(
                public string $name,
                public int $age
            ) {}
        };

        $this->assertEquals('John', $person->name);
        $this->assertEquals(30, $person->age);
    }

    
}