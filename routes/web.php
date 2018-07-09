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
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

/*----------------------------------Customer---------------------------------------*/

Route::get('/customerList', 'CustomerController@customerList')->middleware('auth');
Route::get('/vendorList', 'CustomerController@vendorList')->middleware('auth');
Route::get('/getAddCustomer/{chk}', 'CustomerController@getAddCustomer')->middleware('auth');
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
Route::get('/deleteJournalEntries/{id}','JournalController@DeletetNJournalEntry')->middleware('auth');//New INSERTION ROUTE
Route::get('/getJournalEntries/{id}','JournalController@GetJournalEntries')->middleware('auth');
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
Route::group([ 'middleware' => ['role:inv-manage|admin|ware1-manage|ware2-manage|ware3-manage|ware4-manage|ware5-manage']], function() {

    Route::get('/warehouse' ,'InventoryController@warehouse_list')->middleware('role:inv-manage|admin');
    Route::get('/warehouseAdd' ,'InventoryController@warehouse_add')->middleware('role:inv-manage|admin');
    Route::post('/addWarehouse', 'InventoryController@addWarehouse')->middleware('role:inv-manage|admin');
    Route::get('/getEditWarehouse/{id}', 'InventoryController@getEditWarehouse')->middleware('role:inv-manage|admin');
    Route::post('/editWarehouse', 'InventoryController@editWarehouse')->middleware('role:inv-manage|admin');


    Route::get('/grn', 'InventoryController@grn_list');
    Route::get('/grnAdd' ,'InventoryController@grn_add');
    Route::post('/insertGrn','InventoryController@insertGrn');
    Route::get('/getEditGrn/{id}', 'InventoryController@getEditGrn');
    Route::get('/editGrnDetail', 'InventoryController@editGrnDetail');
    Route::post('/updateGrn','InventoryController@updateGrn');
    Route::get('/deleteGrnDetail', 'InventoryController@deleteGrnDetail');
    Route::get('/getGrnDetailBeforeDelete', 'InventoryController@getGrnDetailBeforeDelete');


    Route::get('/challan', 'InventoryController@challan_list');
    Route::get('/challanAdd' ,'InventoryController@challan_add');
    Route::post('/insertChallan','InventoryController@insertChallan');
    Route::get('/getEditChallan/{id}', 'InventoryController@getEditChallan');
    Route::get('/editChallanDetail', 'InventoryController@editChallanDetail');
    Route::get('/deleteChallanDetail', 'InventoryController@deleteChallanDetail');
    Route::post('/updateChallan','InventoryController@updateChallan');
    Route::get('/getChallanDetailBeforeDelete', 'InventoryController@getChallanDetailBeforeDelete');




    Route::get('/editStockDetail', 'InventoryController@editStockDetail')->middleware('auth');
    Route::get('/deleteStockDetail', 'InventoryController@deleteStockDetail')->middleware('auth');
    Route::post('/updateStock','InventoryController@updateStock')->middleware('auth');

    Route::get('/getEditStock/{id}', 'InventoryController@getEditStock')->middleware('auth');
    Route::get('/stockAdd' ,'InventoryController@stock_add')->middleware('auth');
    Route::get('/stock', 'InventoryController@stock_list')->middleware('auth');
    Route::get('/getStockDetail', 'InventoryController@getStockDetail')->middleware('auth');
    Route::post('/insertStock','InventoryController@insertStock')->middleware('auth');


            /*----------------------------Inventory Reports-------------------------------*/


    Route::get('/warehouseReport' ,'InventoryController@warehouseReport')->middleware('role:inv-manage|admin');
    Route::get('/getWarehouseReport' ,'InventoryController@getWarehouseReport')->middleware('role:inv-manage|admin');
    Route::get('/ProductsatReorderLevel' ,'InventoryController@ProductsatReorderLevel')->middleware('role:inv-manage|admin');
    Route::get('/vendorsReport' ,'InventoryController@vendorsReport')->middleware('role:inv-manage|admin');
    Route::get('/getVendorReport' ,'InventoryController@getVendorReport')->middleware('role:inv-manage|admin');
    Route::get('/productSummary' ,'InventoryController@productSummary')->middleware('role:inv-manage|admin');
    Route::get('/productDeatil' ,'InventoryController@productDeatil')->middleware('role:inv-manage|admin');
    Route::get('/getProductSummaryByCategory' ,'InventoryController@getProductSummaryByCategory')->middleware('role:inv-manage|admin');

    Route::get('/warehouseReportPdf/{id}',array('as'=>'warehouseReportPdf','uses'=>'InventoryController@warehouseReportPdf'));
    Route::get('/productsatReorderLevelPdf',array('as'=>'productsatReorderLevelPdf','uses'=>'InventoryController@productsatReorderLevelPdf'));
    Route::get('/vendorReportPdf/{id}',array('as'=>'vendorReportPdf','uses'=>'InventoryController@vendorReportPdf'));
    Route::get('/productSummaryPdf',array('as'=>'productSummaryPdf','uses'=>'InventoryController@productSummaryPdf'));
    Route::get('/productSummaryByCategoryPdf/{id}',array('as'=>'productSummaryByCategoryPdf','uses'=>'InventoryController@productSummaryByCategoryPdf'));
    Route::get('/productDetailPdf',array('as'=>'productDetailPdf','uses'=>'InventoryController@productDetailPdf'));

});
/*-------------------------------------------------------Procurement---------------------------------------------------------------------*/
//Purchase Order--------------------------------------------------------------------------------------
Route::get('/getPurchaseOrders' ,'PurchaseController@getPurchaseOrders')->middleware('auth');
Route::get('/getFilterPurchaseOrder' ,'PurchaseController@getFilterPurchaseOrder')->middleware('auth');
Route::get('/getAddPurchase' ,'PurchaseController@getAddPurchase')->middleware('auth');
Route::get('/getPurchaseOrder/{id}' ,'PurchaseController@getPurchaseOrder')->middleware('auth');
Route::post('/insertPurchaseOrder' ,'PurchaseController@insertPurchaseOrder')->middleware('auth');
Route::get('/deletePurchaseOrder/{id}' ,'PurchaseController@deletePurchaseOrder')->middleware('auth');
    /*-----------------------------------------------------Print Procurment----------------------------*/
    Route::post('purchase/print' ,'PurchaseController@purchasePrint')->middleware('auth');
    Route::get('/getOrderDetailPdf','PurchaseController@getOrderDetailPdf')->middleware('auth');
    Route::get('/getPurchaseOrderPdf','PurchaseController@getPurchaseOrderPdf')->middleware('auth');


//Request For Purchase-------------------------------------------------------------------------------

Route::get('/getRequestPurchase' ,'RequestPurchaseController@getRequests')->middleware('auth');
Route::get('/getFilterRequestPurchase' ,'RequestPurchaseController@getFilterRequestPurchase')->middleware('auth');
Route::get('/getAddRequestPurchase' ,'RequestPurchaseController@getAddRequestPurchase')->middleware('auth');
Route::get('/getRequestPurchase/{id}' ,'RequestPurchaseController@getRequestPurchase')->middleware('auth');
Route::post('/insertRequestPurchase' ,'RequestPurchaseController@insertRequestPurchase')->middleware('auth');
Route::get('/deleteRequestPurchase/{id}' ,'RequestPurchaseController@deletePurchaseRequest')->middleware('auth');
    /*-----------------------------------------------------Print Procurment----------------------------*/
    Route::post('requestPurchase/print' ,'RequestPurchaseController@requestPurchasePrint')->middleware('auth');
    /* Route::get('/getOrderDetailPdf','RequestPurchaseController@getOrderDetailPdf')->middleware('auth');
    Route::get('/getPurchaseOrderPdf','RequestPurchaseController@getPurchaseOrderPdf')->middleware('auth'); */

/*----------------------------------------------------------Pay Roll---------------------------------------------------------------------*/

//Employee------------------------------------------------------------------------------------------------

Route::get('/employeeList', 'EmployeeController@employeeList')->middleware('auth');
Route::get('/getAddEmployee', 'EmployeeController@getAddEmployee')->middleware('auth');
Route::get('/getEditEmployee/{id}', 'EmployeeController@getEditEmployee')->middleware('auth');
Route::post('/addEmployee', 'EmployeeController@addEmployee')->middleware('auth');
Route::post('/editEmployee', 'EmployeeController@editEmployee')->middleware('auth');

//Employee Advance------------------------------------------------------------------------------------------------

Route::get('/employeeAdvanceList', 'EmployeeAdvanceController@employeeAdvanceList')->middleware('auth');
Route::get('/getAddEmployeeAdvance', 'EmployeeAdvanceController@getAddEmployeeAdvance')->middleware('auth');
Route::get('/getEditEmployeeAdvance/{id}', 'EmployeeAdvanceController@getEditEmployeeAdvance')->middleware('auth');
Route::post('/addEmployeeAdvance', 'EmployeeAdvanceController@addEmployeeAdvance')->middleware('auth');
Route::post('/editEmployeeAdvance', 'EmployeeAdvanceController@editEmployeeAdvance')->middleware('auth');

//Employee Allowance------------------------------------------------------------------------------------------------

Route::get('/employeeAllowanceList', 'EmployeeAllowanceController@employeeAllowanceList')->middleware('auth');
Route::get('/getAddEmployeeAllowance', 'EmployeeAllowanceController@getAddEmployeeAllowance')->middleware('auth');
Route::get('/getEditEmployeeAllowance/{id}', 'EmployeeAllowanceController@getEditEmployeeAllowance')->middleware('auth');
Route::post('/addEmployeeAllowance', 'EmployeeAllowanceController@addEmployeeAllowance')->middleware('auth');
Route::post('/editEmployeeAllowance', 'EmployeeAllowanceController@editEmployeeAllowance')->middleware('auth');

//Employee Deduction------------------------------------------------------------------------------------------------

Route::get('/employeeDeductionList', 'EmployeeDeductionController@employeeDeductionList')->middleware('auth');
Route::get('/getAddEmployeeDeduction', 'EmployeeDeductionController@getAddEmployeeDeduction')->middleware('auth');
Route::get('/getEditEmployeeDeduction/{id}', 'EmployeeDeductionController@getEditEmployeeDeduction')->middleware('auth');
Route::post('/addEmployeeDeduction', 'EmployeeDeductionController@addEmployeeDeduction')->middleware('auth');
Route::post('/editEmployeeDeduction', 'EmployeeDeductionController@editEmployeeDeduction')->middleware('auth');

//Employee Salary------------------------------------------------------------------------------------------------

Route::get('/employeeSalaryList', 'EmployeeSalaryController@employeeSalaryList')->middleware('auth');
Route::get('/getAddEmployeeSalary', 'EmployeeSalaryController@getAddEmployeeSalary')->middleware('auth');
Route::get('/getEditEmployeeSalary/{id}', 'EmployeeSalaryController@getEditEmployeeSalary')->middleware('auth');
Route::post('/addEmployeeSalary', 'EmployeeSalaryController@addEmployeeSalary')->middleware('auth');
Route::post('/editEmployeeSalary', 'EmployeeSalaryController@editEmployeeSalary')->middleware('auth');

//Employee Payroll------------------------------------------------------------------------------------------------

Route::get('/employeePayrollList', 'PayrollController@employeePayrollList')->middleware('auth');
Route::get('/getAddEmployeePayroll', 'PayrollController@getAddEmployeePayroll')->middleware('auth');
Route::post('/addPayrollMonth', 'PayrollController@addPayrollMonth')->middleware('auth');
Route::post('/editPayrollMonth', 'PayrollController@editPayrollMonth')->middleware('auth');
Route::get('/getEditEmployeePayroll/{id}', 'PayrollController@getEditEmployeePayroll')->middleware('auth');
Route::get('/deletePayrollEntry/{id}', 'PayrollController@deletePayrollEntry')->middleware('auth');
Route::post('/addEmployeePayroll', 'PayrollController@addEmployeePayroll')->middleware('auth');
    /*Print Payroll */
    Route::get('/printPayroll/{id}', 'PayrollController@printPayroll')->middleware('auth');

/*----------------------------------------------------------User Management-----------------------------------------------------------------*/

//User Registration-----------------------------------------------------------------------------------------------

Route::get('/userList', 'UserManagement\UserRegistrationController@userList')->middleware('auth');
Route::get('/getAddUser', 'UserManagement\UserRegistrationController@getAddUser')->middleware('auth');
Route::get('/getEditUser/{userId}/{roleId}', 'UserManagement\UserRegistrationController@getEditUser')->middleware('auth');
Route::post('/addUser', 'UserManagement\UserRegistrationController@addUser')->middleware('auth');
Route::post('/editUser', 'UserManagement\UserRegistrationController@editUser')->middleware('auth');
Route::get('/deleteUser/{id}', 'UserManagement\UserRegistrationController@deleteUser')->middleware('auth');

//Warehouse Assignment---------------------------------------------------------------------------------------------

Route::get('/userWarehouseList', 'UserManagement/UserRegistrationController@userWarehouseList')->middleware('auth');
Route::get('/getAddUserWarehouse', 'UserManagement/UserRegistrationController@getAddUserWarehouse')->middleware('auth');
Route::get('/getEditUserWarehouse/{id}', 'UserManagement/UserRegistrationController@getEditUserWarehouse')->middleware('auth');
Route::post('/addUserWarehouse', 'UserManagement/UserRegistrationController@addUserWarehouse')->middleware('auth');
Route::post('/editUserWarehouse', 'UserManagement/UserRegistrationController@editUserWarehouse')->middleware('auth');