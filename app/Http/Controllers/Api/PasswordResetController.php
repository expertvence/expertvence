<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // 🔹 SEND OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);

        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        // 📧 Send Mail
        Mail::raw(
            "Your ExpertVence OTP is: {$otp}\nValid for 10 minutes.",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('ExpertVence Password Reset OTP');
            }
        );

        return response()->json([
            'message' => 'OTP sent to email',
        ]);
    }

    // 🔹 RESET PASSWORD
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = PasswordOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || $record->expires_at->isPast()) {
            return response()->json([
                'message' => 'Invalid or expired OTP',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // 🔥 OTP invalidate
        $record->delete();

        return response()->json([
            'message' => 'Password reset successful',
        ]);
    }
}

