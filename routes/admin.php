<?php


use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\RiderController;
use App\Http\Controllers\Api\Rider\ZoneController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return redirect(route('admin.login.index'));
});

Route::get('/admin',[LoginController::class,'login'])->name('admin.login.index');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::post('/login', [LoginController::class, 'authentication'])->name('admin.login.store');
Route::get('/{id}', [LoginController::class, 'isSeen'])->name('admin.isseen');


//------------ USER ROUTES START -------------------------//
Route::group(['prefix' => 'admin/user'],function(){
    Route::get('/',[UserController::class,'index'])->name('admin.user.index');
    Route::get('/delete/{id}',[UserController::class,'delete'])->name('admin.user.delete');
});
//------------ USER ROUTES END -------------------------//

//------------ PHARMACY ROUTES START -------------------------//
Route::group(['prefix' => 'admin/pharmacy'], function () {
    Route::get('/', [PharmacyController::class, 'index'])->name('admin.pharmacy.index');
    
    Route::post('accountApprove', [PharmacyController::class, 'accountApprove'])->name('admin.pharmacy.account');
    
    Route::get('/delete/{id}', [PharmacyController::class, 'delete'])->name('admin.pharmacy.delete');
    
    Route::post('/changeZone/{id}', [PharmacyController::class, 'changeZone'])->name('admin.pharmacy.changeZone');
    
    Route::post('/orderAllowed/{id}', [PharmacyController::class, 'orderAllowed'])->name('admin.pharmacy.orderAllowed');
     
});
//------------ PHARMACY ROUTES END -------------------------//

//------------ ORDER ROUTES START -------------------------//
Route::group(['prefix' => 'admin/order'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
    Route::get('order-details/{id}', [OrderController::class, 'details'])->name('admin.order.details');
});
//------------ ORDER ROUTES START -------------------------//

//------------ REPORT ROUTES START -------------------------//
Route::group(['prefix' => 'admin/dashboard'], function () {
    Route::get('/', [ReportController::class, 'getDashboard'])->name('admin.dashboard');
});
//------------ REPORT ROUTES START -------------------------//

//------------ PROFILE ROUTES START -------------------------//
Route::group(['prefix' => 'admin/profile'], function () {
    Route::get('/', [LoginController::class, 'profile'])->name('admin.profile.index');
     Route::post('update', [LoginController::class, 'profileUpdate'])->name('admin.profile.update');
      Route::post('changePass', [LoginController::class, 'changePass'])->name('admin.profile.password');
});
//------------ PROFILE ROUTES END -------------------------//

//------------ PRODUCT ROUTES START -------------------------//
Route::group(['prefix' => 'admin/product'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('store', [ProductController::class, 'store'])->name('admin.product.store');
});
//------------ PRODUCT ROUTES END -------------------------//

//------------ WITHDRAW ROUTES START -------------------------//
Route::group(['prefix' => 'admin/withdraw'], function () {
    Route::get('/', [WithdrawalController::class, 'index'])->name('admin.withdraw.index');
    Route::get('transactions/{id}', [WithdrawalController::class, 'transaction'])->name('admin.withdraw.details');
    Route::post('approveWithdrawal', [WithdrawalController::class, 'approveWithdrawal'])->name('admin.withdrawal.approve');
});
//------------ WITHDRAW ROUTES START -------------------------//



//------------ Rider ROUTES START -------------------------//
Route::group(['prefix' => 'admin/rider'],function(){
    
    Route::get('/',[RiderController::class,'index'])->name('admin.rider.index');
    Route::get('/changeStatus/{id}',[RiderController::class, 'changeStatus'])->name('admin.rider.changeStatus');
    
    Route::post('/assignZone/{id}',[ZoneController::class, 'assignZone'])->name('admin.rider.assignZone');

    Route::get('/report/view/{id}',[RiderController::class,'report'])->name('admin.rider.report');
    
    Route::get('/report/track/{id}',[RiderController::class,'track'])->name('admin.rider.track');
    
});
//------------ Rider ROUTES END -------------------------//


