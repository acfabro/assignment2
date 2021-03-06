<?php

/**
 * routes.php - this file registers http routes
 * for code simplicity, use regex for route name
 */

use Acfabro\Assignment2\Helpers\App;
use Acfabro\Assignment2\Http\FieldController;
use Acfabro\Assignment2\Http\Request;
use Acfabro\Assignment2\Http\Response;
use Acfabro\Assignment2\Http\Route;
use Acfabro\Assignment2\Http\SubscriberController;
use Acfabro\Assignment2\Requests\CreateFieldRequest;
use Acfabro\Assignment2\Requests\CreateSubscriberRequest;
use Acfabro\Assignment2\Requests\UpdateFieldRequest;
use Acfabro\Assignment2\Requests\UpdateSubscriberRequest;

//////////////////////////////////////////////
// list all subscribers
Route::get('/^\/api\/subscriber$/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    return $controller->list($request->input('limit'), $request->input('offset'));
});

//////////////////////////////////////////////
// read one subscriber
Route::get('/^\/api\/subscriber\/\d+$/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    $parts = explode('/', $request->getUri());

    return $controller->read($parts[3]);
});

//////////////////////////////////////////////
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

//////////////////////////////////////////////
// update subscriber
Route::patch('/^\/api\/subscriber\/\d+/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    $updateSubscriberRequest = new UpdateSubscriberRequest($request);
    $result = $updateSubscriberRequest->validate(); // as instructed validate before sending to controller

    // if validation failed
    if (!$result) {
        return new Response(400, 'Validation Error');
    }

    return $controller->update($updateSubscriberRequest, $updateSubscriberRequest->getId());
});

//////////////////////////////////////////////
// delete subscriber
Route::delete('/^\/api\/subscriber\/\d+/', function (Request $request) {
    $controller = App::container(SubscriberController::class);
    $parts = explode('/', $request->getUri());

    return $controller->delete($parts[3]);
});

//////////////////////////////////////////////
// create field
Route::post('/^\/api\/field/', function (Request $request) {
    $controller = App::container(FieldController::class);
    $createFieldRequest = new CreateFieldRequest($request);
    $result = $createFieldRequest->validate(); // as instructed validate before sending to controller

    // if validation failed
    if (!$result) {
        return new Response(400, 'Validation Error');
    }

    return $controller->create($createFieldRequest);
});

//////////////////////////////////////////////
// update field
Route::patch('/^\/api\/field\/\d+/', function (Request $request) {
    $controller = App::container(FieldController::class);
    $updateFieldRequest = new UpdateFieldRequest($request);
    $result = $updateFieldRequest->validate(); // as instructed validate before sending to controller

    // if validation failed
    if (!$result) {
        return new Response(400, 'Validation Error');
    }

    return $controller->update($updateFieldRequest);
});

//////////////////////////////////////////////
// delete field
Route::delete('/^\/api\/field\/\d+/', function (Request $request) {
    $controller = App::container(FieldController::class);
    $parts = explode('/', $request->getUri());

    return $controller->delete($parts[3]);
});

//////////////////////////////////////////////
// options field, any request
Route::options('/.*/', function (Request $request) {
    return new Response(200);
});

//////////////////////////////////////////////
// all other routes exhausted, so this must be 404
Route::default(function () {
    return new Response(404, 'Route not found');
});