<?php


namespace Acfabro\Assignment2\Database;


use Acfabro\Assignment2\Helpers\Env;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Connection
 *
 * Database connection
 *
 * @package Acfabro\Assignment2\Database
 */
class Connection
{
    protected static $instance;

    /**
     * Database connection singleton
     */
    public static function instance()
    {
        // return if already instantiated
        if (!empty(self::$instance)) return self::$instance;

        // otherwise make new
        $capsule = new Capsule;
        $capsule->addConnection([
            'database' => Env::get('DB_NAME', 'mailerlite'),
            'username' => Env::get('DB_USERNAME', 'homestead'),
            'password' => Env::get('DB_PASSWORD', 'secret'),
            'host' => Env::get('DB_HOST', 'localhost'),
            'port' => Env::get('DB_PORT', 3306),
            'driver' => 'mysql',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return self::$instance = $capsule->getConnection();
    }
}