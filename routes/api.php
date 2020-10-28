<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    
    return $request->user();
});


//Route::prefix('api/')->group(function(){

    Route::get('showproductcategories','APIController@showProductCategories');
    Route::post('insertSignupDetails','APIController@insertSignupDetails');
    //Route::get('showproductlist','APIController@showProductList');
    //Route::post('getProducts','APIController@getProducts');
    
    

    Route::post('getpackageproductdetail','APIController@getPackageProductDetail');

    Route::post('user/register', 'APIRegisterController@register');

    Route::post('user/forgotpassword','APIRegisterController@ForgotPassword');
    
    Route::post('user/login', 'APILoginController@login');

    /*Routes for forgot password */
    
   // Route::post('user/forgotpassword','APIForgotPasswordController@forgot');

   //Route::post('user/resetpassword','APIForgotPasswordController@doReset');

    
    
    /* End Routes for forgot password */



    Route::post('getmultiplepackageproductsdetail','APIController@getPackageProductsWithDetail');
    
    Route::post('getcategoryproductdetail','APIController@getCategoryProductDetail');
    
    Route::post('getPackageName','APIController@getPackageName');

    //Route::post('placemobileorder','APIController@PlaceMobileOrder');

    Route::post('mobileshowordersales','APIController@MobileShowOrderSales');

    Route::post('singleorderhistorydetail','APIController@SingleMobileShowOrderSalesWithPackage');

    //Route::post('orderhistory','APIController@MultipleMobileShowOrderSalesWithPackage');

    //Route::post('singleorderdetail','APIController@SingleOrderDetail');
    
    //Route::post('forgotpassword','APIController@ForgotPassword');
    
    //Route::post('changepassword','APIController@ChangePassword');
    
    Route::post('login','APIController@Login');
    
    Route::post('trackingorderstatus','APIController@TrackingOrderStatus');

    Route::post('changeordertrackingstatus','APIController@ChangeOrderTrackingStatus');
    
    /*
    Route::middleware('jwt.auth')->get('poscustomers', function(Request $request) {
        //return auth()->user();
    });
    */
    /*
    Route::group(['middleware' => ['jwt.auth']], function() {
        

        Route::post('singleorderhistorydetail','APIController@SingleMobileShowOrderSalesWithPackage');

        Route::post('orderhistory','APIController@MultipleMobileShowOrderSalesWithPackage');
        
        Route::post('placemobileorder','APIController@PlaceMobileOrder');
       
    });
    */
    
    /*
    Route::group(['middleware' => ['jwt.auth']], function() {
        
        \Config::set('auth.providers.users.model', \App\Poscustomer::class);
        Route::post('singleorderhistorydetail','APIController@SingleMobileShowOrderSalesWithPackage');

        Route::post('orderhistory','APIController@MultipleMobileShowOrderSalesWithPackage');
        
        Route::post('placemobileorder','APIController@PlaceMobileOrder');
       
    });

    */

    
    Route::group(['middleware' => ['poscustomer.auth']], function() {
        
       // \Config::set('auth.providers.users.model', \App\Poscustomer::class);
        //Route::post('singleorderdetail','APIController@SingleMobileShowOrderSalesWithPackage');
        Route::post('singleorderdetail','APIController@SingleOrderDetail');

        Route::post('orderhistory','APIController@MultipleMobileShowOrderSalesWithPackage');
        
        Route::post('placemobileorder','APIController@PlaceMobileOrder');
       
    });


    /*
    Route::group(['middleware' => ['assign.guard:poscustomer','jwt.auth']],function (){
        Route::post('getPackageName','APIController@getPackageName');	
    });
    */



//});
