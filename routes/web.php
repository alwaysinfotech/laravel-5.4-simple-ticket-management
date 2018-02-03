<?php 
    /*
    Laravel5.4
    Module Name: Ticket Management System
    Description : Very simple and useful ticket management system for Laravel 5.4 for frontend logged in users and Admin panel. Dependency is Auth module
    Author URI: http://www.alwaysinfotech.com/
    Author: Deepak Verma
    */
?>
<?php
/*Start Ticket Route*/
/*Frontend Routes*/
Route::get('/create-ticket','TicketController@getTicket')->middleware('auth');
Route::post('/add-ticket','TicketController@addTicket')->middleware('auth');
Route::get('/ticket','TicketController@openTicket')->middleware('auth');

/*Admin Routes*/
Route::get('/admin/manage-ticket','TicketController@getManageTicket')->middleware('auth');
Route::post('/delete-ticket','TicketController@deleteTicket')->middleware('auth');
Route::post('/action-delete-ticket','TicketController@deleteActionTicket')->middleware('auth');
Route::get('/ticket/{ticket_id}','TicketController@myTicket')->middleware('auth');
Route::post('/comment','TicketController@sendComment')->middleware('auth');

/*End Ticket Route*/
