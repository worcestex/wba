<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

use function event;
use function response;

class AuthController extends Controller
{

   public function __construct()
   {
       $this->middleware('guest')->except('logout', 'refreshUser');
    }

    public function token(Request $request)
    {
 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /////////////


        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        
        return response()->json(['user' => $user, 'token' => $user->createToken($user->email)->plainTextToken]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->user_id = User::generateUserIdKey($user);
        $user->password = Hash::make($request->password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();
        event(new Registered($user));

        return response()->json(['message' => 'user successfully registered', 'user' => $user]);
    }

    public function profile(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();

        return response()->json(['token' => $user->createToken($user->name)->plainTextToken]);
        
    }

//    public function login(Request $request)
//    {
//        $credentials = $request->validate([
//            'email' => ['required', 'email'],
//            'password' => ['required'],
//        ]);
//
//        if (Auth::attempt($credentials)) {
//            $request->session()->regenerate();
//
//            return response()->json(['message' => 'Logged in successfully', 'user' => Auth::user()], 201);
//        }
//        throw ValidationException::withMessages([
//            'email' => ['The provided credentials are incorrect.'], 422
//        ]);
//
//        return response()->json(['message' => 'Invalid token', 'authed' => false]);
//    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'successful-logout'
        ]);
    }
}
