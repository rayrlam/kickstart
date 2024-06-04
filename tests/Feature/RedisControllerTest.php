<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RedisControllerTest extends TestCase
{
    use WithoutMiddleware, WithFaker;

    /**
     * Test saving data to Redis.
     *
     * @return void
     */
    public function testSaveToRedis()
    {
        // Generate random key and value
        $key = $this->faker->unique()->word;
        $value = $this->faker->sentence;

        // Make POST request to save data
        $response = $this->postJson('/redis/save', ['key' => $key, 'value' => $value]);

        // Assert response status and content
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Data saved to Redis',
                 ]);
    }

    /**
     * Test getting data from Redis.
     *
     * @return void
     */
    public function testGetFromRedis()
    {
        // Generate random key and value
        $key = $this->faker->unique()->word;
        $value = $this->faker->sentence;

        // First, save the data
        $this->postJson('/redis/save', ['key' => $key, 'value' => $value]);

        // Then, get the data
        $response = $this->getJson('/redis/get?key=' . $key);

        // Assert response status and content
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => $value,
                 ]);
    }
}
