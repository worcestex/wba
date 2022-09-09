<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
 

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
/*
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Request reset password token
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
    ? response()->json(['status' => __($status)], 200)
    : response()->json(['errors' => __($status)], 400);

})->middleware('guest')->name('password.email');

// Reset password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => ['required',
        'string',
        Password::min(8)
            ->mixedcase()
            ->numbers()
            ->symbols()
            ->uncompromised(),
        'confirmed']
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(15));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['status' => __($status)], 200)
        : response()->json(['errors' => __($status)], 400);

})->middleware('guest')->name('password.update');

*/
////////
/*
Route::group([
    'prefix' => 'admin',
    'as' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['admin']

], function(){
    Route::get('admin/auctions',[AuctionController::class,'index'])->middleware(['admin']);
});
*/