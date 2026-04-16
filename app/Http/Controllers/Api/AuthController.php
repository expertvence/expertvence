<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'email_verified_at' => null, // not verified yet
        'remember_token' => Str::random(60), // temporary token
        'role' => 'user', // Default role
    ]);

    $verificationLink = url("/verify-email?token={$user->remember_token}&email={$user->email}");

    Mail::raw(
        "Hello {$user->name}, verify your email: {$verificationLink}",
        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verify Your Email');
        }
    );

    return response()->json([
        'message' => 'Registration successful. Please check your email to verify your account.',
    ]);
}

public function verifyEmail(Request $request)
{
    $email = $request->query('email');
    $token = $request->query('token');

    $user = User::where('email', $email)->firstOrFail();

    if ($user->remember_token !== $token) {
        return redirect(env('FRONTEND_URL', 'http://localhost') . '/login?verified=false');
    }

    if (!$user->email_verified_at) {
        $user->email_verified_at = now();
        $user->save();
    }

    // OTP/token invalidation optional
    $user->remember_token = Str::random(60);
    $user->save();

    return redirect(env('FRONTEND_URL', 'http://localhost') . '/login?verified=true');
}






public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // 🔹 CHECK EMAIL VERIFICATION
    if (!$user->email_verified_at) {
        return response()->json([
            'message' => 'Please verify your email before logging in.'
        ], 403);
    }

    // ✅ JWT TOKEN
    $token = JWTAuth::fromUser($user);

    return response()->json([
        'token' => $token,
        'user' => $user,
        'token_type' => 'Bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60,
        'should_redirect_to_admin' => in_array($user->role, ['admin', 'super_admin']),
    ]);
}


    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
