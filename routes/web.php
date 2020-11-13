<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
// router restaurant

$router->group(['prefix' =>'restaurant'], function () use ($router) {

    $router->post('/', 'RestaurantsController@store');
    $router->get('/', 'RestaurantsController@index');
    $router->get('/{id}', 'RestaurantsController@show');
    $router->put('/{id}', 'RestaurantsController@update');
    $router->delete('/{id}', 'RestaurantsController@destroy');
    $router->get('/{id}/restore', 'RestaurantsController@restory');

});

$router->group(['prefix' =>'resvation'], function () use ($router) {

    $router->post('/', 'ReservationsController@store');
    $router->get('/', 'ReservationsController@index');
    $router->get('/{id}', 'ReservationsController@show');
    $router->delete('/{id}', 'ReservationsController@destroy');

});