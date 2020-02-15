<?php

/**
 * routes.php - this file registers http routes
 * for code simplicity, use regex for route name
 */

use Acfabro\Assignment2\Helpers\App;
use Acfabro\Assignment2\Http\Request;
use Acfabro\Assignment2\Http\Response;
use Acfabro\Assignment2\Http\Route;
use Acfabro\Assignment2\Http\SubscriberController;
use Acfabro\Assignment2\Requests\CreateSubscriberRequest;
use Acfabro\Assignment2\Requests\UpdateSubscriberRequest;

/** @var Request $request */

// list all subscribers
Route::get('/^\/api\/subscriber$/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    return $controller->list($request->input('limit'), $request->input('offset'));
});

// read one subscriber
Route::get('/^\/api\/subscriber\/\d+$/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    $parts = explode('/', $request->getUri());

    return $controller->read($parts[3]);

});

// create new subscriber
Route::post('/^\/api\/subscriber$/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    $createSubscriberRequest = new CreateSubscriberRequest($request);
    $result = $createSubscriberRequest->validate(); // as instructed validate before sending to controller

    // if validation failed
    if (!$result) {
        return new Response(400, 'Validation Error');
    }

    return $controller->create($createSubscriberRequest);
});

// update subscriber
Route::patch('/^\/api\/subscriber\/\d+/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    $updateSubscriberRequest = new UpdateSubscriberRequest($request);
    $result = $updateSubscriberRequest->validate();

    // if validation failed
    if (!$result) {
        return new Response(400, 'Validation Error');
    }

    return $controller->update($updateSubscriberRequest, $updateSubscriberRequest->getId());
});

// delete subscriber
Route::patch('/^\/api\/subscriber\/\d+/', function (Request $request) {

});

// create field
Route::patch('/^\/api\/subscriber\/\d+/', function (Request $request) {

});

// update field
Route::patch('/^\/api\/subscriber\/\d+/', function (Request $request) {

});

// delete field
Route::patch('/^\/api\/subscriber\/\d+/', function (Request $request) {

});

Route::default(function () {
    return new Response(404, 'Route not found');
});