<?php

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


$router->group(['prefix' => 'api'], function () use ($router) {
    // $router->get('students',  ['uses' => 'StudentController@showAll']);

    $router->get('student/{id}', ['uses' => 'StudentController@read']);

    $router->get('students', ['uses' => 'StudentController@readAll']);

    $router->post('student', ['uses' => 'StudentController@create']);

    $router->delete('student/{id}', ['uses' => 'StudentController@delete']);

    $router->put('student/{id}', ['uses' => 'StudentController@update']);

    // routes for documents
    $router->get('student/{id}/document/{document_id}', ['uses' => 'StudentDocumentController@read']);

    $router->post('student/{id}/document', ['uses' => 'StudentDocumentController@create']);

    $router->delete('student/{id}/document/{document_id}', ['uses' => 'StudentDocumentController@delete']);

    $router->post('student/{id}/document/{document_id}', ['uses' => 'StudentDocumentController@update']);

  });


  