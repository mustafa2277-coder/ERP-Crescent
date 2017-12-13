<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*----------------------------------Customer---------------------------------------*/

Route::get('/customerList', 'CustomerController@customerList');
Route::get('/getAddCustomer', 'CustomerController@getAddCustomer');
Route::get('/getEditCustomer/{id}', 'CustomerController@getEditCustomer');
Route::post('/addCustomer', 'CustomerController@addCustomer');
Route::post('/editCustomer', 'CustomerController@editCustomer');



/*----------------------------------Account Heads---------------------------------------*/
Route::get('/getAccountHeads','AccountHeadController@GetAccountHeads');
Route::get('/addAccountHead' ,'AccountHeadController@GetAccountHeadForm');
Route::get('/editAccountHead/{id}','AccountHeadController@GetAccountHeadById');
Route::post('/insertAccountHead','AccountHeadController@InsertAccountHead');
Route::post('/updateAccountHead','AccountHeadController@UpdateAccountHead');

/*----------------------------------Journal---------------------------------------*/
Route::get('/getJournals','JournalController@GetJournals');
Route::get('/addJournal' ,'JournalController@GetJournalForm');
Route::get('/editJournal/{id}','JournalController@GetJournalById');
Route::post('/insertJournal','JournalController@InsertJournal');
Route::post('/updateJournal','JournalController@UpdateJournal');

/*----------------------------------Journal Entry---------------------------------------*/
Route::get('/getJournalEntries','JournalController@GetJournalEntries');
Route::get('/addJournalEntry' ,'JournalController@GetJournalEntryForm');
Route::post('/insertJournalEntry','JournalController@InsertJournalEntry');

