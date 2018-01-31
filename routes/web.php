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

    /*----------------------------------Print Account Heads  ---------------------------------------*/
    Route::get('/getAccountHeadsPdf','AccountHeadController@GetAccountHeadsPdf')->middleware('auth');
    Route::get('/GetTestPdf','AccountHeadController@GetTestPdf')->middleware('auth');//Test with FPDF
    
    /*-----------------------------------End Account Heads -----------------------------------------*/


/*----------------------------------Journal---------------------------------------*/
Route::get('/getJournals','JournalController@GetJournals')->middleware('auth');
Route::get('/addJournal' ,'JournalController@GetJournalForm')->middleware('auth');
Route::get('/editJournal/{id}','JournalController@GetJournalById')->middleware('auth');
Route::post('/insertJournal','JournalController@InsertJournal')->middleware('auth');
Route::post('/updateJournal','JournalController@UpdateJournal')->middleware('auth');

    /*------------------------------------Print Journal-----------------------------------------*/
    Route::get('/getJournalPdf','JournalController@GetJournalPdf')->middleware('auth');
    Route::get('/getVoucherPdf','JournalController@GetVoucherPdf')->middleware('auth');
    Route::get('/getJournalItemsPdf','JournalController@GetJournalItemsPdf')->middleware('auth');
    /*----------------------------------End Print Journal ---------------------------------------*/


/*----------------------------------Journal Entry---------------------------------------*/
Route::match(['get', 'post'],'/getJournalEntries','JournalController@GetJournalEntries')->middleware('auth');
Route::get('/addJournalEntry' ,'JournalController@GetJournalEntryForm')->middleware('auth');
Route::post('/insertJournalEntry','JournalController@InsertJournalEntry')->middleware('auth');//OLD INSERTION ROUTE
Route::post('/insertNJournalEntry','JournalController@InsertNJournalEntry')->middleware('auth');//New INSERTION ROUTE
Route::post('/getJournalEntriesByDate','JournalController@GetJournalEntriesByDate')->middleware('auth');
Route::post('getProjectsByCustomerId' ,'JournalController@GetProjectsByCustomerId')->middleware('auth');
Route::get('/getJournalEntriesListView' ,'JournalController@GetJournalEntriesListView')->middleware('auth');
Route::get('/getFilterJournalEntriesList' ,'JournalController@GetFilterJournalEntriesList')->middleware('auth');
Route::post('journalEntry/print' ,'JournalController@jprint')->middleware('auth');

/*----------------------------------Journal Item----------------------------*/
Route::get('/getJournalItems','JournalController@GetJournalItems')->middleware('auth');

/*----------------------------------Reports---------------------------------------*/
Route::get('/getGeneralLedger','ReportController@GetGeneralLedger')->middleware('auth');
Route::get('/getJournalEntryByEntrynum','ReportController@GetJournalEntryByEntrynum')->middleware('auth');
Route::get('/getBalanceSheet','ReportController@GetBalanceSheet')->middleware('auth');
Route::get('/getProfitLoss','ReportController@GetProfitLoss')->middleware('auth');
Route::get('/getGeneralLedgerView','ReportController@GetGeneralLedgerView')->middleware('auth');
Route::get('/getFilterGeneralLedgerList' ,'ReportController@GetFilterGeneralLedgerList')->middleware('auth');
Route::get('/getGeneralLedgerListByParentId' ,'ReportController@GetGeneralLedgerListByParentId')->middleware('auth');


Route::get('/getFilterGeneralLedgerList2' ,'ReportController@GetFilterGeneralLedgerList2')->middleware('auth');

    /*----------------------------------Print Report  ---------------------------------------*/
    Route::get('/getBalanceSheetPdf','ReportController@GetBalanceSheetPdf')->middleware('auth');
    Route::get('/getProfitLossPdf','ReportController@GetProfitLossPdf')->middleware('auth');
    /*----------------------------------End Print Report --------------------------------------*/



/*----------------------------------Inventory---------------------------------------*/
Route::get('/warehouse' ,'InventoryController@warehouse_list')->middleware('auth');
Route::get('/warehouseAdd' ,'InventoryController@warehouse_add')->middleware('auth');
Route::post('/addWarehouse', 'InventoryController@addWarehouse')->middleware('auth');
Route::get('/getEditWarehouse/{id}', 'InventoryController@getEditWarehouse')->middleware('auth');
Route::post('/editWarehouse', 'InventoryController@editWarehouse')->middleware('auth');


Route::get('/grn', 'InventoryController@grn_list')->middleware('auth');
Route::get('/grnAdd' ,'InventoryController@grn_add')->middleware('auth');
Route::post('/insertGrn','InventoryController@insertGrn')->middleware('auth');
Route::get('/getEditGrn/{id}', 'InventoryController@getEditGrn')->middleware('auth');
Route::get('/editGrnDetail', 'InventoryController@editGrnDetail')->middleware('auth');
Route::post('/updateGrn','InventoryController@updateGrn')->middleware('auth');
Route::get('/deleteGrnDetail', 'InventoryController@deleteGrnDetail')->middleware('auth');
Route::get('/getGrnDetailBeforeDelete', 'InventoryController@getGrnDetailBeforeDelete')->middleware('auth');


Route::get('/challan', 'InventoryController@challan_list')->middleware('auth');
Route::get('/challanAdd' ,'InventoryController@challan_add')->middleware('auth');
Route::post('/insertChallan','InventoryController@insertChallan')->middleware('auth');
Route::get('/getEditChallan/{id}', 'InventoryController@getEditChallan')->middleware('auth');
Route::get('/editChallanDetail', 'InventoryController@editChallanDetail')->middleware('auth');
Route::get('/deleteChallanDetail', 'InventoryController@deleteChallanDetail')->middleware('auth');
Route::post('/updateChallan','InventoryController@updateChallan')->middleware('auth');
Route::get('/getChallanDetailBeforeDelete', 'InventoryController@getChallanDetailBeforeDelete')->middleware('auth');





Route::get('/editStockDetail', 'InventoryController@editStockDetail')->middleware('auth');
Route::get('/deleteStockDetail', 'InventoryController@deleteStockDetail')->middleware('auth');
Route::post('/updateStock','InventoryController@updateStock')->middleware('auth');

Route::get('/getEditStock/{id}', 'InventoryController@getEditStock')->middleware('auth');
Route::get('/stockAdd' ,'InventoryController@stock_add')->middleware('auth');
Route::get('/stock', 'InventoryController@stock_list')->middleware('auth');
Route::get('/getStockDetail', 'InventoryController@getStockDetail')->middleware('auth');
Route::post('/insertStock','InventoryController@insertStock')->middleware('auth');


        /*----------------------------Inventory Reports-------------------------------*/


Route::get('/warehouseReport' ,'InventoryController@warehouseReport')->middleware('auth');
Route::get('/getWarehouseReport' ,'InventoryController@getWarehouseReport')->middleware('auth');
Route::get('/ProductsatReorderLevel' ,'InventoryController@ProductsatReorderLevel')->middleware('auth');
Route::get('/vendorsReport' ,'InventoryController@vendorsReport')->middleware('auth');
Route::get('/getVendorReport' ,'InventoryController@getVendorReport')->middleware('auth');
Route::get('/productSummary' ,'InventoryController@productSummary')->middleware('auth');
Route::get('/productDeatil' ,'InventoryController@productDeatil')->middleware('auth');
Route::get('/getProductSummaryByCategory' ,'InventoryController@getProductSummaryByCategory')->middleware('auth');

Route::get('/warehouseReportPdf/{id}',array('as'=>'warehouseReportPdf','uses'=>'InventoryController@warehouseReportPdf'));
Route::get('/productsatReorderLevelPdf',array('as'=>'productsatReorderLevelPdf','uses'=>'InventoryController@productsatReorderLevelPdf'));
Route::get('/vendorReportPdf/{id}',array('as'=>'vendorReportPdf','uses'=>'InventoryController@vendorReportPdf'));
Route::get('/productSummaryPdf',array('as'=>'productSummaryPdf','uses'=>'InventoryController@productSummaryPdf'));
Route::get('/productSummaryByCategoryPdf/{id}',array('as'=>'productSummaryByCategoryPdf','uses'=>'InventoryController@productSummaryByCategoryPdf'));
Route::get('/productDetailPdf',array('as'=>'productDetailPdf','uses'=>'InventoryController@productDetailPdf'));
