<?php

namespace Acfabro\Assignment2Tests\Models;

use Acfabro\Assignment2\Helpers\RedisCache;
use PHPUnit\Framework\TestCase;

class RedisCacheTest extends TestCase
{

    public function testPut()
    {
        $redis = new RedisCache();
        $redis->set('testkey','testvalue');
        $this->assertSame($redis->get('testkey'), 'testvalue');

    }

    public function testGet()
    {
        $redis = new RedisCache();
        $redis->set('testkey','testvalue');
        $this->assertSame($redis->get('testkey'), 'testvalue');
    }

    public function testConnect()
    {
        $redis = new RedisCache();
        $this->assertTrue($redis->connect());
    }
}
