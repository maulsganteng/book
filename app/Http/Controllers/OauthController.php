<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class OauthController extends Controller
{
    // Redirect ke Google
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Callback dari Google
    public function handleProviderCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan gauth_id atau email
            $findUser = User::where('gauth_id', $googleUser->id)
                            ->orWhere('email', $googleUser->email)
                            ->first();

            if ($findUser) {
                // Jika user sudah ada, update gauth_id jika belum ada
                if (!$findUser->gauth_id) {
                    $findUser->update([
                        'gauth_id' => $googleUser->id,
                        'gauth_type' => 'google',
                    ]);
                }

                // Login user
                Auth::login($findUser);
            } else {
                // Jika user belum ada, buat user baru
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'gauth_id' => $googleUser->id,
                    'gauth_type' => 'google',
                    'password' => bcrypt('default-google-password'), // Default password untuk akun Google
                ]);

                Auth::login($newUser);
            }

            // Redirect ke halaman utama setelah login
            return redirect('/')->with('success', 'Login successful.');

        } catch (Exception $e) {
            // Tangani error dan tampilkan pesan
            return redirect('/login')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}