<?php

/**
 * register.php - this file registers immplentations to the container
 */

use Acfabro\Assignment2\Helpers\App;
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
