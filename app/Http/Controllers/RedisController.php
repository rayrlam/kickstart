<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    protected $ttl = 300; // Time to live in seconds (5 minutes)

    public function save(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');

        if (is_null($key) || is_null($value)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input'], 400);
        }

        try {
            Redis::set($key, $value);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'message' => 'Data saved to Redis']);
    }

    public function get(Request $request)
    {
        $key = $request->input('key');

        if (is_null($key)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input'], 400);
        }

        try {
            $value = Redis::get($key);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'data' => $value]);
    }

    public function incrementVisitorCount(Request $request)
    {
        $userId = $request->input('user_id');
        if (is_null($userId)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input'], 400);
        }

        $key = 'online_user:' . $userId;

        try {
            Redis::setex($key, $this->ttl, time());
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'message' => 'User activity recorded']);
    }

    public function getVisitorCount()
    {
        try {
            $keys = Redis::keys('online_user:*');
            $count = count($keys);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'online_visitors' => $count]);
    }
}