<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\BidIncrementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeliveryZoneController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\LotCollectionPointController;
use App\Http\Controllers\LotPickupMethodController;
use App\Http\Controllers\LotRulesController;
use App\Http\Controllers\LotStorageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\RegistrationFeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWatchlistController;
use App\Http\Controllers\UserWishListController;
use App\Http\Controllers\VatRatesController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/


//Route::post('/admin/login', [AdminAuthController::class, 'login']);
//Route::post('/admin/create-admin', [AdminAuthController::class, 'createAdmin']);
//Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');



//// ADMIN DASHBOARD


Route::group(['middleware' => ['auth:sanctum','verified','admin']], function () {

    Route::apiResource('admin/members',UserController::class);

    Route::apiResource('admin/auctions',AuctionController::class);

    Route::apiResource('admin/languages',LanguageController::class);

    Route::apiResource('admin/shipping-method',DeliveryZoneController::class);

    Route::apiResource('admin/order-status',OrderStatusController::class);

    Route::apiResource('admin/vat-rates',VatRatesController::class);

    

});

Route::post('admin/lots', [LotController::class,'store'])->middleware(['auth:sanctum', 'verified']);
Route::put('admin/lots/{lotId}', [LotController::class,'update'])->middleware(['auth:sanctum', 'verified']);
Route::delete('admin/lots/{lotId}', [LotController::class,'destroy'])->middleware(['auth:sanctum', 'verified']);

//Lot Collection Points
Route::get('admin/lots/lot-collection-point',[LotCollectionPointController::class,'index'])->middleware(['auth:sanctum', 'verified']);;
Route::post('admin/lots/lot-collection-point',[LotCollectionPointController::class,'store'])->middleware(['auth:sanctum', 'verified']);;
Route::put('admin/lots/lot-collection-point/{id}',[LotCollectionPointController::class,'update'])->middleware(['auth:sanctum', 'verified']);;
Route::delete('admin/lots/lot-collection-point/{id}', [LotCollectionPointController::class,'destroy'])->middleware(['auth:sanctum', 'verified']);

//Lot Delivery Methods
Route::get('admin/lots/lot-delivery-method',[LotPickupMethodController::class,'index'])->middleware(['auth:sanctum', 'verified']);;
Route::post('admin/lots/lot-delivery-method',[LotPickupMethodController::class,'store'])->middleware(['auth:sanctum', 'verified']);;
Route::put('admin/lots/lot-delivery-method/{id}',[LotPickupMethodController::class,'update'])->middleware(['auth:sanctum', 'verified']);;
Route::delete('admin/lots/lot-delivery-method/{id}', [LotPickupMethodController::class,'destroy'])->middleware(['auth:sanctum', 'verified']);

//Lot Rules Methods
Route::get('admin/lots/lot-rules',[LotRulesController::class,'index'])->middleware(['auth:sanctum', 'verified']);;
Route::post('admin/lots/lot-rules',[LotRulesController::class,'store'])->middleware(['auth:sanctum', 'verified']);;
Route::put('admin/lots/lot-rules/{id}',[LotRulesController::class,'update'])->middleware(['auth:sanctum', 'verified']);;
Route::delete('admin/lots/lot-rules/{id}', [LotRulesController::class,'destroy'])->middleware(['auth:sanctum', 'verified']);

//Lot Storage
Route::get('admin/lots/lot-storage',[LotStorageController::class,'index'])->middleware(['auth:sanctum', 'verified']);;

//Orders
Route::get('admin/orders',[OrderController::class,'index'])->middleware(['auth:sanctum', 'verified']);;
Route::put('admin/orders/{id}',[OrderController::class,'update'])->middleware(['auth:sanctum', 'verified']);;
Route::delete('admin/orders/{id}',[OrderController::class,'destroy'])->middleware(['auth:sanctum', 'verified']);;

//Unpaid orders
Route::get('admin/orders/unpaid',[OrderController::class,'unpaidOrders'])->middleware(['auth:sanctum', 'verified']);;


//Order Status
Route::get('admin/orders',[OrderController::class,'index'])->middleware(['auth:sanctum', 'verified']);;
Route::get('admin/orders',[OrderController::class,'index'])->middleware(['auth:sanctum', 'verified']);;
Route::get('admin/orders',[OrderController::class,'index'])->middleware(['auth:sanctum', 'verified']);;



//Route::post('/admin/login', function (Request $request) {
//    return response()->json(['message'=> 'Wrong Credentials'], 404);
//});

//Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {
//    // Admin Dashboard
//    Route::get('dashboard','AdminController@dashboard')->name('dashboard');
//});