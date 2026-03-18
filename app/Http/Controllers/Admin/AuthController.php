<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke halaman Home (bukan dashboard)
        if (session('admin_logged_in')) {
            return redirect()->route('admin.home.index');
        }
        
        return view('admin.auth.login');
    }

    /**
     * Proses request login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Hardcode credential dev only
        if ($request->username === 'kreatif153' && $request->password === '153kreatif') {
            session(['admin_logged_in' => true]);
            
            // Handle remember me opsional: kita hanya set session jadi tidak berpengaruh besar,
            // tapi memberi experience yang diminta user.
            
            return response()->json([
                'success' => true,
                'redirect' => route('admin.home.index')
            ]);
        }

        // Return error validation secara spesifik ke password agar muncul di bawah input
        return response()->json([
            'message' => 'Username atau password yang Anda masukkan salah.',
            'errors' => [
                'password' => ['Username atau password tidak sesuai.']
            ]
        ], 422);
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
