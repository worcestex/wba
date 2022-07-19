<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\BidIncrementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\LotCollectionPointController;
use App\Http\Controllers\LotPickupMethodController;
use App\Http\Controllers\LotRulesController;
use App\Http\Controllers\LotStorageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegistrationFeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWatchlistController;
use App\Http\Controllers\UserWishListController;
use App\Http\Controllers\VerifyEmailController;

use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//Route::get('profile', function () {
//    // Only verified users may enter...
//})->middleware('verified');

Auth::routes(['verify' => true]);

Route::post("/register", [AuthController::class, "register"]);

// Verify email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Resend link to verify email
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

// Web Login Route - XSRF Token

Route::group(['middleware' => ['web']], function () {
    
    Route::post("/login", [LoginController::class, "authenticate"]);
    Route::post("/logout", [LoginController::class, "logout"]);
    
});


// Mobile Auth Routes
Route::post("/loginToken", [AuthController::class, "token"]);
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get("/user", [AuthController::class, 'profile']);
    Route::get("/refresh", [AuthController::class, 'refresh']);
    Route::post("/logoutToken", [AuthController::class, 'logout']);
});

//Users
Route::apiResource('users', UserController::class)->middleware(['auth:sanctum', 'verified']);

//User Wishlist
Route::get('users/{id}/wishlist', [UserWishListController::class, 'show'])->middleware(['auth:sanctum', 'verified']);
Route::post('users/{id}/wishlist', [UserWishListController::class, 'store'])->middleware(['auth:sanctum', 'verified']);
Route::delete('users/{userId}/wishlist/{wishListId}', [UserWishListController::class, 'destroy'])->middleware(['auth:sanctum', 'verified']);

//User Watchlist
Route::get('users/{id}/watchlist', [UserWatchlistController::class, 'show'])->middleware(['auth:sanctum', 'verified']);
Route::post('users/{id}/watchlist', [UserWatchlistController::class, 'store'])->middleware(['auth:sanctum', 'verified']);
Route::delete('users/{userId}/watchlist/{watchlistId}', [UserWatchlistController::class, 'destroy'])->middleware(['auth:sanctum', 'verified']);

// Lots
Route::get('lots/{id}/bids', [LotController::class, 'showLotBidHistory'])->middleware(['auth:sanctum', 'verified']);
Route::get('lots/{id}', [LotController::class,'show'])->middleware(['auth:sanctum', 'verified']);
Route::get('lots', [LotController::class,'index'])->middleware(['auth:sanctum', 'verified']);
Route::put('lots/{id}', [LotController::class,'update'])->middleware(['auth:sanctum', 'verified']);


//Stripe

Route::get('stripe-payment', [RegistrationFeeController::class, 'handleGet'])->middleware(['auth:sanctum', 'verified']);;
Route::post('stripe-payment', [RegistrationFeeController::class, 'purchaseRegistrationFee'])->name('stripe.payment')->middleware(['auth:sanctum', 'verified']);;


// Auctions
Route::prefix('auctions')->group(function () {
    Route::get('/next-auction', [AuctionController::class, 'fetchNextAuction']);
    Route::get('/past-auctions/items', [AuctionController::class, 'fetchItemsFromPastAuctions']);
    Route::get('/current-auctions/items', [AuctionController::class, 'fetchItemsFromCurrentAuctions']);
});





// Bids
Route::get('bids', [BidController::class, 'index'])->middleware(['auth:sanctum', 'verified']);
Route::get('bids/{id}', [BidController::class, 'show'])->middleware(['auth:sanctum', 'verified']);
Route::post('bids', [BidController::class, 'store'])->middleware(['auth:sanctum', 'verified']);
Route::delete('admin/bids/{bidId}', [BidController::class,'destroy'])->middleware(['auth:sanctum', 'verified']);


Route::prefix('admin/bids')->group(function () {
    Route::get('/latest-bids', [BidController::class, 'fetchItemsFromLatestBids']);
});

// Bid Increment
Route::put('bid-increments/{id}', [BidIncrementController::class, 'update']) ->middleware(['auth:sanctum', 'verified']);
Route::get('bid-increments', [BidIncrementController::class, 'show']) ->middleware(['auth:sanctum', 'verified']);
//get request


Route::get('change-language/{locale}', [LanguageController::class, 'changeLanguage']);





// Contact
Route::post('contact', [ContactController::class, 'store']);
Route::post('contact', [ContactController::class, 'sendMail']);

include('admin_api.php');