<?php


namespace Acfabro\Assignment2\Helpers;


use Redis;

/**
 * Class RedisCache
 *
 * Wrapper for phpredis. aim is to make this operate as quietly as possible
 *
 * @package Acfabro\Assignment2\Helpers
 */
class RedisCache
{
    /**
     * @var \Redis
     */
    protected $redis;

    public function connect()
    {
        try {
            $this->redis = new Redis();
            return $this->redis->connect(
                Env::get('REDIS_STRING', '127.0.0.1'),
                Env::get('REDIS_PORT', 6379)
            );
        } catch (\Exception $e) {
            return false;
        }
    }

    public function set($name, $value, $options=['ex'=>300])
    {
        try {
            if (!$this->redis) $this->connect();
            return $this->redis->set($name, $value, $options);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function get($name)
    {
        try {
            if (!$this->redis) $this->connect();
            return $this->redis->get($name);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function del($name)
    {
        try {
            if (!$this->redis) $this->connect();
            return $this->redis->del($name);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected static $instance;

    public static function instance()
    {
        if (!self::$instance) self::$instance = new RedisCache();
        return self::$instance;
    }

}