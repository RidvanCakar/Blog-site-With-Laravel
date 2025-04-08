<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Doğrulama işlemi
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // Şifre doğrulaması ekleyebilirsiniz
        ]);

        // Kullanıcıyı kaydetme
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log kaydını veritabanına kaydetme
        Log::channel('db')->info("Yeni kullanıcı kaydoldu: {$user->email}");

        return redirect('/login')->with('success', 'Kayıt başarılı, giriş yapabilirsiniz.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Kullanıcı doğrulama
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $email = Auth::user()->email;
            $ip = $request->ip();

            // Başarılı giriş log kaydı
            Log::channel('db')->info("Kullanıcı giriş yaptı: {$email} | IP: {$ip}");

            return redirect('/posts')->with('success', 'Giriş başarılı!');
        }

        // Başarısız giriş log kaydı
        Log::channel('db')->warning("Başarısız giriş denemesi: {$request->input('email')} | IP: {$request->ip()}");

        // Hata mesajını döndürme
        return back()->withErrors(['email' => 'Girdiğiniz bilgiler hatalı.']);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $email = Auth::user()->email;

            // Çıkış log kaydı
            Log::channel('db')->info("Kullanıcı çıkış yaptı: {$email}");
        }

        Auth::logout();

        return redirect('/login')->with('success', 'Başarıyla çıkış yapıldı.');
    }
}
