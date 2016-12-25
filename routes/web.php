<?php


Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/ticket/create', 'TroubleTicketController@create');
Route::get('/ticket/{ticket}', 'TroubleTicketController@show');

Route::post('/ticket', 'TroubleTicketController@store');




