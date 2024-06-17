<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisControllerTest extends TestCase
{
    use WithoutMiddleware, WithFaker, RefreshDatabase;

    /**
     * Clear Redis database before each test
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushall();
    }

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

    /**
     * Test Increment Visitor Count
     *
     * @return void
     */
    public function testIncrementVisitorCount()
    {
        $response = $this->json('POST', '/api/increment-visitor-count', ['user_id' => 1]);
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success', 'message' => 'User activity recorded']);

        $response = $this->json('POST', '/api/increment-visitor-count', ['user_id' => 2]);
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success', 'message' => 'User activity recorded']);

        $this->assertEquals(2, count(Redis::keys('online_user:*')));
    }

    /**
     * Test Get Visitor Count
     *
     * @return void
     */
    public function testGetVisitorCount()
    {
        Redis::setex('online_user:1', 300, time());
        Redis::setex('online_user:2', 300, time());

        $response = $this->json('GET', '/api/get-visitor-count');
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success', 'online_visitors' => 2]);

        Redis::del('online_user:1');

        $response = $this->json('GET', '/api/get-visitor-count');
        $response->assertStatus(200)
                 ->assertJson(['status' => 'success', 'online_visitors' => 1]);
    }
}