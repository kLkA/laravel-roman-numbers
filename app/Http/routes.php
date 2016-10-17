<?php
$api = app('Dingo\Api\Routing\Router');
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

$app->get('/', function () use ($app) {
    return $app->version();
});


$api->version('v1', function ($api) {
    $api->get('number/recent', 'App\Http\Controllers\NumberController@recent');
    $api->get('number/top', 'App\Http\Controllers\NumberController@top');
    $api->get('number/{id}', 'App\Http\Controllers\NumberController@show');
});