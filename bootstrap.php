<?php

/**
 * bootstrap.php - this file boostraps resources
 */

use Acfabro\Assignment2\Database\Connection;
use Acfabro\Assignment2\Helpers\App;
use Symfony\Component\Dotenv\Dotenv;

/////////////////////
// bootstrap services

// dotenv
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// database
Connection::instance();

// app container and
App::container();
require_once __DIR__.'/register.php';

// routes
require_once __DIR__.'/routes.php';

// container registration
require_once __DIR__.'/register.php';

// helpers
require_once __DIR__.'/helpers.php';
