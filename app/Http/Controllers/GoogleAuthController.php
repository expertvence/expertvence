<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        if (!$clientId || !$clientSecret) {
            return redirect($this->frontendUrl() . '/login?error=google_not_configured');
        }

        $returnTo = (string) request()->query('return_to', '/');
        if (!str_starts_with($returnTo, '/') || str_starts_with($returnTo, '//') || str_contains($returnTo, "\\")) {
            $returnTo = '/';
        }

        $state = Str::random(48);
        session(['google_oauth_state' => $state, 'google_oauth_return_to' => $returnTo]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => config('services.google.redirect'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]));
    }

    public function callback(): RedirectResponse
    {
        $expectedState = (string) session()->pull('google_oauth_state', '');
        $receivedState = (string) request()->query('state', '');
        $returnTo = (string) session()->pull('google_oauth_return_to', '/');
        if (!$expectedState || !$receivedState || !hash_equals($expectedState, $receivedState)) {
            return $this->loginRedirect($returnTo, 'google_state');
        }
        if (request()->query('error') || !request()->query('code')) {
            return $this->loginRedirect($returnTo, 'google_cancelled');
        }

        try {
            $tokens = Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
                'code' => request()->query('code'),
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => config('services.google.redirect'),
                'grant_type' => 'authorization_code',
            ])->throw()->json();

            $googleUser = Http::withToken($tokens['access_token'])->timeout(15)
                ->get('https://www.googleapis.com/oauth2/v3/userinfo')->throw()->json();
            if (empty($googleUser['sub']) || empty($googleUser['email']) || empty($googleUser['email_verified'])) {
                return $this->loginRedirect($returnTo, 'google_unverified');
            }

            $user = User::where('google_id', $googleUser['sub'])->first();
            if (!$user) {
                $user = User::where('email', $googleUser['email'])->first();
            }
            if ($user?->role === 'admin') {
                return $this->loginRedirect($returnTo, 'google_admin_account');
            }
            if (!$user) {
                $user = new User();
                $user->password = Hash::make(Str::random(64));
            }

            $user->role = 'user';
            $user->google_id = $googleUser['sub'];
            $user->name = $googleUser['name'] ?? $user->name ?? $googleUser['email'];
            $user->email = $googleUser['email'];
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->save();

            $token = JWTAuth::fromUser($user);
            $fragment = http_build_query(['token' => $token, 'redirect' => $returnTo]);
            return redirect()->away($this->frontendUrl() . '/auth/google/result#' . $fragment);
        } catch (\Throwable $exception) {
            report($exception);
            return $this->loginRedirect($returnTo, 'google_failed');
        }
    }

    private function loginRedirect(string $returnTo, string $error): RedirectResponse
    {
        return redirect()->away($this->frontendUrl() . '/login?' . http_build_query([
            'redirect' => $returnTo,
            'error' => $error,
        ]));
    }

    private function frontendUrl(): string
    {
        return rtrim((string) env('FRONTEND_URL', config('app.url')), '/');
    }
}