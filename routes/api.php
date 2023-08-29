<?php

use App\Http\Controllers\Api\Customer\ForgotPassController;
use App\Http\Controllers\Api\Common\NotificationController;
use App\Http\Controllers\Api\Customer\LoginController;
use App\Http\Controllers\Api\Customer\OrderController;
use App\Http\Controllers\Api\Customer\PharmacyController;
use App\Http\Controllers\Api\Common\ProductController;
use App\Http\Controllers\Api\Common\ReportController as CommonReportController;
use App\Http\Controllers\Api\Customer\RatingController;
use App\Http\Controllers\Api\Customer\RegisterController;
use App\Http\Controllers\Api\Customer\UploadPrescriptionController;
use App\Http\Controllers\Api\Pharmassist\LoginController as PharmassistLoginController;
use App\Http\Controllers\Api\Pharmassist\PrescriptionController;
use App\Http\Controllers\Api\Pharmassist\RegisterController as PharmassistRegisterController;
use App\Http\Controllers\Api\Rider\AuthController;
use App\Http\Controllers\Api\Rider\ForgetPasswordController;
use App\Http\Controllers\Api\Rider\OrderController as RiderOrderController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\Api\Rider\ReportController;
use App\Http\Controllers\Api\Rider\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//------------- CUSTOMER AUTHENTICATION API ROUTES -------------------//
Route::post('logincustomer', [LoginController::class, 'loginCustomer']);
Route::get('customer/deleteUser', [LoginController::class, 'deleteUser']);
Route::post('createcustomer', [RegisterController::class, 'CreateCustomer']);
Route::post('forgotpassword', [ForgotPassController::class, 'forgotPassword']);
Route::post('verifyOtp', [ForgotPassController::class, 'verifyOtp']);
Route::post('changePassword', [ForgotPassController::class, 'changePassword']);
Route::post('updatePassword', [RegisterController::class, 'updatePassword']);
//------------- CUSTOMER AUTHENTICATION API ROUTES END -------------------//
Route::post('cancelOrder', [OrderController::class, 'cancelOrder']);

Route::get('getSinglePrescription/{id}', [UploadPrescriptionController::class, 'getSinglePrescription']);
Route::post('appNotifications', [NotificationController::class, 'appNotifications']);
Route::get('readNotification/{id}', [NotificationController::class, 'readNotification']);

Route::get('getProduct', [ProductController::class, 'getProduct']);
Route::get('getSingleProduct/{id}', [ProductController::class, 'getSingleProduct']);


Route::get('prescriptionPdf/{id}', [CommonReportController::class, 'prescriptionPdf']);

//------------- PHARMACY AUTHENTICATION API ROUTES -------------------//
Route::post('createpharmacy', [PharmassistRegisterController::class, 'createPharmacy']);
Route::post('loginpharmacy', [PharmassistLoginController::class, 'loginPharmacy']);
Route::post('pharmacy/updateKeys', [PharmassistLoginController::class, 'updateKeys']);
Route::get('pharmacy/deletePharmacy', [PharmassistLoginController::class, 'deletePharmacy']);

Route::post('update/latlong', [NotificationController::class, 'appNotifications']);

//------------- PHARMACY AUTHENTICATION API ROUTES END -------------------//
Route::post('updateLatLong', [LoginController::class, 'updateLatLong']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //------------- CUSTOMER API ROUTES -------------------//
    Route::group(['prefix' => 'customer'], function () {
        Route::post('UpdateCustomer', [RegisterController::class, 'updateCustomer']);
        Route::get('GetAllPharmacy', [PharmacyController::class, 'getPharmacy']);
        Route::post('UploadPrescription', [UploadPrescriptionController::class, 'uploadPrescription']);
        Route::get('getNotificationCustomer', [NotificationController::class, 'getNotificationCustomer']);
        Route::get('GetPrescriptionPricing/{id}', [UploadPrescriptionController::class, 'getPricing']);
        Route::get('getSingleCustomer', [PharmacyController::class, 'getSingleCustomer']);
        Route::post('/addRatings', [RatingController::class, 'addRatings']);
        Route::get('getCustomerPrescriptions', [UploadPrescriptionController::class, 'getCustomerPrescriptions']);
        Route::post('revisePrescription', [OrderController::class, 'revisePrescription']);
        Route::post('updatePrescriptionImage', [UploadPrescriptionController::class, 'updatePrescriptionImage']);
        Route::post('deleteItem', [OrderController::class, 'deleteItem']);
        Route::post('makePayment', [OrderController::class, 'makePayment']);
        Route::post('checkLimit', [OrderController::class, 'checkLimit']);
    });
    //------------- CUSTOMER API ROUTES END -------------------//
});
//------------- PHARMACY API ROUTES -------------------//
Route::group(['prefix' => 'pharmacy'], function () {
    Route::post('cancelOrderPharmacy', [PrescriptionController::class, 'cancelOrderPharmacy']);
    Route::get('getNotificationPharmacy', [NotificationController::class, 'getNotificationPharmacy']);
    Route::get('GetPrescriptions', [PrescriptionController::class, 'getPrescriptions']);
    Route::post('PrescriptionPricing', [PrescriptionController::class, 'prescriptionPricing']);
    Route::get('getSinglePharmacy', [PrescriptionController::class, 'getSinglePharmacy']);
    Route::get('getSinglePrescription/{id}', [PrescriptionController::class, 'getSinglePrescription']);
    Route::post('updatePharmacy', [PharmassistRegisterController::class, 'updatePharmacy']);
    Route::post('updatePrescriptionPricing', [PrescriptionController::class, 'updatePrescriptionPricing']);
    Route::post('pickupStatus', [PrescriptionController::class, 'pickupStatus']);
    Route::post('prescriptionInstruction', [PrescriptionController::class, 'prescriptionInstruction']);
    Route::post('updateInstruction', [PrescriptionController::class, 'updateInstruction']);
    Route::get('deleteInstruction/{id}', [PrescriptionController::class, 'deleteInstruction']);
    Route::get('getPharmacyTransaction', [PharmassistLoginController::class, 'getPharmacyTransaction']);
    Route::post('withdrawalRequest', [PharmassistLoginController::class, 'withdrawalRequest']);
    Route::get('getWithdrawalRequest', [PharmassistLoginController::class, 'getWithdrawalRequest']);

});
//------------- PHARMACY API ROUTES END -------------------//


//------------- Rider API ROUTES -------------------//
Route::group(['prefix' => 'rider'], function () {

    Route::post('create-user', [AuthController::class, 'createUser']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('check-otp', [AuthController::class, 'CheckOtp']);

    Route::post('profile/update', [AuthController::class, 'update']);
    Route::get('getLoginUser', [AuthController::class, 'getLoginUser']);


    Route::post('login', [AuthController::class, 'login']);
    Route::post('change-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::post('checkOtp', [ForgetPasswordController::class, 'checkOtp']);
    Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);

    Route::get('orders', [RiderOrderController::class, 'getAll']);
    Route::post('order/change-status', [RiderOrderController::class, 'order_status']);
    Route::get('order/history', [RiderOrderController::class, 'orderHistory']);

    Route::get('/notifications', [NotificationController::class, 'getNotificationRider']);


    Route::get('/reports/getRides/{date?}', [ReportController::class, 'getRides']);
    Route::get('/reports/getEarned/{date?}', [ReportController::class, 'getEarned']);
    Route::get('/reports/getGraph', [ReportController::class, 'getGraph']);

    Route::post('/update/latlong', [AuthController::class, 'updateLatLong']);

    Route::post('/update/fcmtoken', [AuthController::class, 'updateFcm']);

});
//------------- Rider API ROUTES END -------------------//




//------------- Rider API ROUTES -------------------//
Route::group(['prefix' => 'zones'], function () {

    Route::get('getAll', [ZoneController::class, 'getAll']);

});
//------------- Rider API ROUTES END -------------------//



