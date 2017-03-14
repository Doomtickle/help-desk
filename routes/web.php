<?php


Route::get('/', 'HomeController@index');

Route::post('/beebole_key', 'HomeController@beeboleKey');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/tickets/all', 'TroubleTicketController@index');
    Route::get('/ticket/create', 'TroubleTicketController@create');
    Route::get('/ticket/{ticket}', 'TroubleTicketController@show');
    Route::patch('/ticket/{ticket}', 'TroubleTicketController@update');
    Route::patch('/complete/{ticket}', 'TroubleTicketController@markComplete');
    
    Route::get('/ticket/{ticket}/edit', 'TroubleTicketController@edit');
    Route::get('/notifications/readall', 'NotificationsController@readAll');
    Route::post('/ticket', 'TroubleTicketController@store');

    Route::post('/{ticket}/comment', 'CommentsController@store');

    Route::get('/beebole/companies/seed', 'BeeBoleController@listCompanies');
    Route::get('/beebole/projects/seed', 'BeeBoleController@updateProjects');
    Route::get('/beebole/tasks/seed', 'BeeBoleController@updateTasks');
    Route::get('/beebole/subprojects/seed', 'BeeBoleController@seedSubprojects');
    Route::get('/subprojects/{id}', 'BeeBoleController@getSubprojects');

    Route::get('/agendas/create', 'AgendasController@create');
    Route::post('/agendas', 'AgendasController@store');


    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
