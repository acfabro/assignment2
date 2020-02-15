<?php


namespace Acfabro\Assignment2\Helpers;


use Acfabro\Assignment2\Error\ClientSideException;
use Acfabro\Assignment2\Http\Request;
use Acfabro\Assignment2\Http\Response;
use Acfabro\Assignment2\Http\Route;
use Illuminate\Container\Container;

/**
 * Class App
 *
 * Dependency injection container helper
 *
 * @package Acfabro\Assignment2\Helpers
 */
class App
{
    protected static $container;

    /**
     * Get an item from the container
     * @param string $item name of container item to return if any. if null, it wil return the container instance
     * @return Container
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function container($item = null)
    {
        if (empty(self::$container)) self::$container = Container::getInstance();

        if (!empty($item) && isset(self::$container[$item])) {
            return self::$container[$item];
        }

        if (!empty($item) && !isset(self::$container[$item])) {
            return Container::getInstance()->make($item);
        }

        return self::$container;
    }

    /**
     * Run the application
     */
    public static function run()
    {
        /**
         * @var Request $request
         * @var Response $response
         */

        try {
            // instantiate Request, get input from HTTP
            $request = App::container(Request::class);

            // resolve the route, get the callable and call it
            $callable = Route::resolve($request);

            // get the output
            $response = $callable($request);

            // set cors, content type
            $response->setHeader('Content-Type','application/json');
            $response->setHeader('Access-Control-Allow-Origin','*');
            $response->setHeader('Access-Control-Allow-Methods','GET, POST, PUT, PATCH, DELETE, HEAD');
            $response->setHeader('Access-Control-Allow-Headers','*');
            $response->setHeader('Access-Control-Max-Age', 86400);

            // render the output
            $response->render();

        } catch (ClientSideException $e) {
            // 4xx errors
            $response = new Response($e->getCode(), $e->getMessage());
            $response->render();

        } catch (\Exception $e) {
            // 5xx errors
            $response = new Response($e->getCode(), $e->getMessage());
            $response->render();

        }

    }

}