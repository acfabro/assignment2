<?php


namespace Acfabro\Assignment2\Http;


/**
 * Class Route
 *
 * Use this to register routes
 *
 * @package Acfabro\Assignment2\Http
 */
class Route
{
    /**
     * @var array All routes registered through routes.php
     */
    protected $routes = [];

    /**
     * The default callable when all other routes are not matched
     * @var callable
     */
    protected $default;

    /**
     * Create a get route
     * @param $route
     * @param $callable
     */
    public static function get($route, $callable)
    {
        self::instance()->routes[] = [
            'GET', $route, $callable
        ];
    }

    /**
     * Create a post route
     * @param $route
     * @param $callable
     */
    public static function post($route, $callable)
    {
        self::instance()->routes[] = [
            'POST', $route, $callable
        ];
    }

    /**
     * Create a delete route
     * @param $route
     * @param $callable
     */
    public static function delete($route, $callable)
    {
        self::instance()->routes[] = [
            'DELETE', $route, $callable
        ];
    }

    /**
     * Create a put route
     * @param $route
     * @param $callable
     */
    public static function put($route, $callable)
    {
        self::instance()->routes[] = [
            'PUT', $route, $callable
        ];
    }

    /**
     * Create a patch route
     * @param $route
     * @param $callable
     */
    public static function patch($route, $callable)
    {
        self::instance()->routes[] = [
            'PATCH', $route, $callable
        ];
    }

    /**
     * Create a patch route
     * @param $route
     * @param $callable
     */
    public static function options($route, $callable)
    {
        self::instance()->routes[] = [
            'OPTIONS', $route, $callable
        ];
    }

    /**
     * Create the default route
     * @param $callable

     */
    public static function default($callable)
    {
        self::instance()->default = $callable;
    }

    /**
     * Return all the routes registered
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * getter for the default route
     * @return callable
     */
    public function getDefault()
    {
        return $this->default;
    }

    ////////////////////////////////
    /// static properties and methods
    public static $instance;

    /**
     * Produce the Route singleton
     * @return Route
     */
    public static function instance()
    {
        if (!self::$instance) self::$instance = new Route();
        return self::$instance;
    }

    /**
     * Try to find the callable route based on the request
     * @param Request $request
     * @return callable
     */
    public static function resolve(Request $request)
    {
        // foreach of the routes defined using Route::method()
        foreach (self::instance()->getRoutes() as $route) {
            // check each part
            if (
                // check method
                $route[0] === $request->getMethod() &&

                // check uri via regex
                preg_match($route[1], $request->getUri())
            ) {
                return $route[2];
            }
        }

        // none found, return the default callable
        return self::instance()->default;
    }

}