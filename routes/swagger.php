<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Swagger Routes
|--------------------------------------------------------------------------
|
| This file is used to define the Swagger routes for your application.
| You can customize and add your own routes as needed.
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'documentation',
    'defaults' => [
        'headers' => [
            'Authorization' => 'Bearer {your_token_here}',
        ],
    ],

], function () {
    Route::get('/', '\L5Swagger\Http\Controllers\SwaggerController@api')->name('l5swagger.api');
    Route::get('/oauth2-redirect.html', '\L5Swagger\Http\Controllers\SwaggerController@oauth2Callback');
});
