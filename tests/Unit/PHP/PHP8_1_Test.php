<?php

namespace Tests\Unit\PHP;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

enum Status
{
    case DRAFT;
    case PUBLISHED;
    case ARCHIVED;
}
 
class PHP8_1_Test extends TestCase
{
    use DatabaseTransactions;
    
    public function test_enum()
    {
        $status = Status::PUBLISHED;
        $this->assertInstanceOf(Status::class, $status);
        $this->assertEquals('PUBLISHED', $status->name);
    }

    public function test_first_class_callable_syntax()
    {
        $toLowerCase = strtolower(...);
        $this->assertEquals('hello', $toLowerCase('HELLO'));

        $getLength = strlen(...);
        $this->assertEquals(5, $getLength('Hello'));
    }

    public function testNewInInitializers()
    {
        

        $defaultConfig = new Config();
        $this->assertEmpty($defaultConfig->getOptions());

        $config = new Config(options: ['debug' => true]);
        $this->assertNotEmpty($config->getOptions());
        $this->assertTrue($config->getOptions()['debug']);
    }
}

class Config
{
    public function __construct(
        private array $options = []
    ) {}

    public function getOptions(): array
    {
        return $this->options;
    }
}