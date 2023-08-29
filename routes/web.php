<?php
use App\Http\Controllers\Admin\KanooPayController;
use App\Http\Controllers\Admin\RiderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
Route::get('privacy',[KanooPayController::class, 'privacy']);
Route::get('terms',[KanooPayController::class, 'terms']);
Route::get('rider/privacy/',[RiderController::class, 'privacy']);
Route::get('rider/terms/',[RiderController::class, 'terms']);


Route::get('payment-success',[KanooPayController::class, 'payment']);
Route::get('payment-back',[KanooPayController::class, 'paymentBack']);
require 'admin.php';
Route::get('/clear', function() {

    Artisan::call('config:clear');
   Artisan::call('cache:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');

   return "Cleared!";

});





