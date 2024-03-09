<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;


use Illuminate\Support\Facades\Mail;
use App\Mail\passwordreset;
use App\Mail\ResetPassword;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'wrong credentials'], 401);
        }
        return
            response()->json([
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL(),
                'role' => Auth::user()->role,
            ]);
    }

    public function register(RegisterUserRequest $request)
    {
        DB::enableQueryLog();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->role = $request->role;
        $user->save();
        // dd(DB::getQueryLog());
        return response()->json([
            'message' => 'Successfully created user!',
        ], 201);
    }

    public function generateResetToken(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::all()->where('email', $request->email)->first();
        $id = $user->id;
        $token = Str::random(6);
        Cache::put($token, $id, 5 * 60);
        Mail::to($request->email)->send(new ResetPassword($token));
        return response()->json([
            'token' => $token,
        ], 200);
    }

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);
        $id = Cache::get($request->token);
        if (!$id) {
            return response()->json([
                'message' => 'Invalid token!',
            ], 403);
        }
        $user = User::find($id);
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->save();
        Cache::forget($request->token);
        return response()->json([
            'message' => 'Password successfully reset!',
        ], 200);
    }
}
