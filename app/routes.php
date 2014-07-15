<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('status/index');
});

Route::get('tools/status-update-utility', 'Pjtitle\Controllers\StatusUpdateUtilityController@index');
Route::get('tools/status-update-utility/execute', 'Pjtitle\Controllers\StatusUpdateUtilityController@execute');
Route::get('tools/status-update-utility/logs', 'Pjtitle\Controllers\StatusUpdateUtilityController@logs');
Route::get('tools/status-update-utility/getLog', 'Pjtitle\Controllers\StatusUpdateUtilityController@getLog');

Route::get('tools/batch-creator', 'Pjtitle\Controllers\BatchCreatorUtility@create');
Route::post('tools/batch-creator', 'Pjtitle\Controllers\BatchCreatorUtility@save');

Route::get('dataentry', function() {

    return View::make('dataentry');
});

Route::get('preview-window', function() {

    return View::make('preview');
});


Route::get('aws', function() {

    $filesystem = (new \Pjtitle\Services\AwsFlySystem())->createAdapter();

    $filesystem->write('test/test.txt', 'Hello World');
});