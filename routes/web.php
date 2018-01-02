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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

/*----------------------------------Customer---------------------------------------*/

Route::get('/customerList', 'CustomerController@customerList')->middleware('auth');
Route::get('/vendorList', 'CustomerController@vendorList')->middleware('auth');
Route::get('/getAddCustomer', 'CustomerController@getAddCustomer')->middleware('auth');
Route::get('/getEditCustomer/{id}', 'CustomerController@getEditCustomer')->middleware('auth');
Route::post('/addCustomer', 'CustomerController@addCustomer')->middleware('auth');
Route::post('/editCustomer', 'CustomerController@editCustomer')->middleware('auth');

/*-----------------------------------Project---------------------------------------*/

Route::get('/projectList', 'ProjectController@projectList')->middleware('auth');
Route::get('/getAddProject', 'ProjectController@getAddProject')->middleware('auth');
Route::get('/getEditProject/{id}', 'ProjectController@getEditProject')->middleware('auth');
Route::post('/addProject', 'ProjectController@addProject')->middleware('auth');
Route::post('/editProject', 'ProjectController@editProject')->middleware('auth');

/*-----------------------------------Product Category---------------------------------------*/

Route::get('/categoryList', 'ProductCategoryController@categoryList')->middleware('auth');
Route::get('/getAddCategory', 'ProductCategoryController@getAddCategory')->middleware('auth');
Route::get('/getEditCategory/{id}', 'ProductCategoryController@getEditCategory')->middleware('auth');
Route::get('/getAddSubCategory/{id}', 'ProductCategoryController@getAddSubCategory')->middleware('auth');
Route::post('/addCategory', 'ProductCategoryController@addCategory')->middleware('auth');
Route::post('/editCategory', 'ProductCategoryController@editCategory')->middleware('auth');

/*---------------------------------------Product--------------------------------------------*/

Route::get('/productList', 'ProductController@productList')->middleware('auth');
Route::get('/getAddProduct', 'ProductController@getAddProduct')->middleware('auth');
Route::get('/getEditProduct/{id}', 'ProductController@getEditProduct')->middleware('auth');
Route::post('/addProduct', 'ProductController@addProduct')->middleware('auth');
Route::post('/editProduct', 'ProductController@editProduct')->middleware('auth');


/*----------------------------------Account Heads---------------------------------------*/
Route::get('/getAccountHeads','AccountHeadController@GetAccountHeads')->middleware('auth');
Route::get('/addAccountHead/{id}' ,'AccountHeadController@GetAccountHeadForm')->middleware('auth');
Route::get('/editAccountHead/{id}','AccountHeadController@GetAccountHeadById')->middleware('auth');
Route::post('/insertAccountHead','AccountHeadController@InsertAccountHead')->middleware('auth');
Route::post('/updateAccountHead','AccountHeadController@UpdateAccountHead')->middleware('auth');

/*----------------------------------Journal---------------------------------------*/
Route::get('/getJournals','JournalController@GetJournals')->middleware('auth');
Route::get('/addJournal' ,'JournalController@GetJournalForm')->middleware('auth');
Route::get('/editJournal/{id}','JournalController@GetJournalById')->middleware('auth');
Route::post('/insertJournal','JournalController@InsertJournal')->middleware('auth');
Route::post('/updateJournal','JournalController@UpdateJournal')->middleware('auth');

/*----------------------------------Journal Entry---------------------------------------*/
//Route::get('/getJournalEntries','JournalController@GetJournalEntries')->name('getJournalEntries')->middleware('auth');
// Route::post('/getJournalEntriess','JournalController@GetJournalEntries')->middleware('auth');
Route::match(['get', 'post'],'/getJournalEntries','JournalController@GetJournalEntries')->middleware('auth');

Route::get('/addJournalEntry' ,'JournalController@GetJournalEntryForm')->middleware('auth');
Route::post('/insertJournalEntry','JournalController@InsertJournalEntry')->middleware('auth');

Route::post('/getJournalEntriesByDate','JournalController@GetJournalEntriesByDate')->middleware('auth');
Route::post('getProjectsByCustomerId' ,'JournalController@GetProjectsByCustomerId')->middleware('auth');

// testing 
Route::get('/getJournalEntriesTest' ,'JournalController@GetJournalEntriesTest')->middleware('auth');
Route::get('/getFilterJournalEntriesTest' ,'JournalController@GetFilterJournalEntriesTest')->middleware('auth');

/*----------------------------------Journal Item----------------------------*/
Route::get('/getJournalItems','JournalController@GetJournalItems')->middleware('auth');

/*----------------------------------Reports---------------------------------------*/
Route::get('/getGeneralLedger','ReportController@GetGeneralLedger')->middleware('auth');
Route::get('/getJournalEntryByEntrynum','ReportController@GetJournalEntryByEntrynum')->middleware('auth');
Route::get('/getBalanceSheet','ReportController@GetBalanceSheet')->middleware('auth');
Route::get('/getProfitLoss','ReportController@GetProfitLoss')->middleware('auth');



