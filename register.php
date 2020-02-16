<?php

/**
 * register.php - this file registers immplentations to the container
 * container uses illuminate container
 */

use Acfabro\Assignment2\Helpers\App;
use Acfabro\Assignment2\Helpers\RedisCache;
use Acfabro\Assignment2\Http\Request;

////////////////
// HTTP request
App::container()->bind(
    Request::class,
    function ($app) {
        $body = file_get_contents('php://input');
        return new Request(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_GET,
            $_POST,

            // request body for non-GET requests
            $_SERVER['REQUEST_METHOD'] !== 'GET' ? $body : null
        );
    }
);

////////////////
// Redis Cache singleton
App::container()->bind(
    RedisCache::class,
    function ($app) {
        return RedisCache::instance();
    }
);
