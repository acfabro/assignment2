<?php


namespace Acfabro\Assignment2\Helpers;


use Redis;

class RedisCache
{
    /**
     * @var \Redis
     */
    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect(
            Env::get('REDIS_STRING', '127.0.0.1'),
            Env::get('REDIS_PORT', 6379)
        );
    }

    protected static $instance;

    public static function instance()
    {
        if (!self::$instance) self::$instance = new RedisCache();
    }

}