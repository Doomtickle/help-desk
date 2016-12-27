<?php


Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/tickets/all', 'TroubleTicketController@index');

Route::get('/ticket/create', 'TroubleTicketController@create');
Route::get('/ticket/{ticket}', 'TroubleTicketController@show');
Route::patch('/ticket/{ticket}', 'TroubleTicketController@update');

Route::get('/ticket/{ticket}/edit', 'TroubleTicketController@edit');


Route::post('/ticket', 'TroubleTicketController@store');




