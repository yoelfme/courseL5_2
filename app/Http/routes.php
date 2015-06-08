<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [
    'as' => 'tickets.latest',
    'uses' => 'TicketsController@latest'
]);

Route::get('/populares', [
    'as' => 'tickets.popular',
    'uses' => 'TicketsController@popular'
]);

Route::get('/pendientes', [
    'as' => 'tickets.open',
    'uses' => 'TicketsController@open'
]);

Route::get('/tutoriales', [
    'as' => 'tickets.closed',
    'uses' => 'TicketsController@closed'
]);

Route::get('/solicitud/{id}', [
    'as' => 'tickets.details',
    'uses' => 'TicketsController@details'
]);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'auth'], function(){

    // Crear solicitudes
    Route::get('/solicitar', [
        'as' => 'tickets.create',
        'uses' => 'TicketsController@create'
    ]);

    Route::post('/solicitar', [
        'as' => 'tickets.store',
        'uses' => 'TicketsController@store'
    ]);

    // Votar
    Route::post('votar/{id}', [
        'as' => 'votes.submit',
        'uses' => 'VotesController@submit'
    ]);

    Route::delete('votar/{id}', [
        'as' => 'votes.destroy',
        'uses' => 'VotesController@destroy'
    ]);

    Route::post('comentar/{id}', [
        'as'    => 'comments.submit',
        'uses'  => 'CommentsController@submit',
    ]);

});