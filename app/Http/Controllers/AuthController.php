<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
   public function verifyOtp(Request $request)
{
    $user = \App\Models\User::find(session('2fa_user_id'));

    if (!$user) {
        return redirect('/login');
    }

    if ($user->otp !== $request->otp) {
        return back()->with('error', 'OTP salah');
    }

    if (now()->gt($user->otp_expired_at)) {
        return back()->with('error', 'OTP expired');
    }

    // login user
    Auth::login($user);

    // hapus OTP
    $user->update([
        'otp' => null,
        'otp_expired_at' => null
    ]);

    session()->forget('2fa_user_id');

    return redirect('/dashboard');
}
}