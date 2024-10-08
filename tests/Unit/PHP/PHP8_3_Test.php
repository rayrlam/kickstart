<?php

namespace Tests\Unit\PHP;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Unit\PHP\ChildClass;
use Random\Randomizer;

class PHP8_3_Test extends TestCase
{
    use DatabaseTransactions;
    
    public function test_json_validate()
    {
        $this->assertTrue(json_validate('{"name": "Peter", "age": 18}'));
        $this->assertFalse(json_validate('{name: "Peter", age: 18}'));
    }

    public function test_randomizer_additions()
    {
        $randomizer = new Randomizer();
        
        // Test getBytesFromString
        $result = $randomizer->getBytesFromString('abcdef', 3);
        $this->assertIsString($result);
        $this->assertEquals(3, strlen($result));
        
        // Test getFloat
        $float = $randomizer->getFloat(0, 1);
        $this->assertIsFloat($float);
        $this->assertGreaterThanOrEqual(0, $float);
        $this->assertLessThanOrEqual(1, $float);
        
        // Test nextFloat
        $nextFloat = $randomizer->nextFloat();
        $this->assertIsFloat($nextFloat);
        $this->assertGreaterThanOrEqual(0, $nextFloat);
        $this->assertLessThan(1, $nextFloat);
    }

    public function test_new_override_attribute() {
        $child = new ChildClass();
        $this->assertEquals('Child method',  $child->doSomething());
    }
}