<?php

/**
 * Main entry point file
 */

// load auto loaders
use Acfabro\Assignment2\Helpers\App;

require_once '../vendor/autoload.php';

// bootstrap resources
require_once '../bootstrap.php';

// run the app
App::run();
