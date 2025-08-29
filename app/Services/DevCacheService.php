<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class DevCacheService
{
    protected string $store = 'redis';

    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::store($this->store)->get($key, $default);
    }

    public function put(string $key, mixed $value, int $ttl = 300): void
    {
        Cache::store($this->store)->put($key, $value, $ttl);
    }

    public function remember(string $key, int $ttl, \Closure $callback): mixed
    {
        return Cache::store($this->store)->remember($key, $ttl, $callback);
    }

    public function forget(string $key): void
    {
        Cache::store($this->store)->forget($key);
    }

    public function flush(): void
    {
        $store = Cache::store($this->store)->getStore();

        if (method_exists($store, 'flush')) {
            $store->flush();
        } else {
            // fallback: forget all known keys, or do nothing
            Cache::store($this->store)->clear(); // for ArrayStore
        }
    }
}
