<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yoeunes\Toastr\Facades\Toastr;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:super_admins|unique:clients',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|string|in:superAdmin,client,user'
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        // تسجيل المستخدم بناءً على نوعه
        switch ($request->input('type')) {
            case 'superAdmin':
                $user = SuperAdmin::create($data);
                $guard = 'superAdmin';
                break;
            case 'client':
                $user = Client::create($data);
                $guard = 'client';
                break;
            case 'user':
            default:
                $user = User::create($data);
                $guard = 'web';
                break;
        }

        // تسجيل الدخول تلقائيًا بعد التسجيل
        Auth::guard($guard)->login($user);

        return redirect()->route('home'); // توجيه المستخدم إلى الصفحة الرئيسية بعد التسجيل
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = SuperAdmin::where('email', $credentials['email'])->first();
        $guard = 'superAdmin';

        if (!$user) {
            $user = Client::where('email', $credentials['email'])->first();
            $guard = 'client';
        }

        if (!$user) {
            $user = User::where('email', $credentials['email'])->first();
            $guard = 'web';
        }

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard($guard)->login($user);
            Toastr::success('Login successful', 'Success');
            if ($guard === 'superAdmin') {
                return view('home');
            } elseif ($guard === 'client') {
                return view('home');
            } elseif ($guard === 'web'){
                return view('home');
            }
        }

        Toastr::error('Invalid email or password', 'Error');
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('superAdmin')->check()) {
            Auth::guard('superAdmin')->logout();
        } elseif (Auth::guard('client')->check()) {
            Auth::guard('client')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        Toastr::success('Logout successful', 'Success');
        return redirect()->route('login');
    }

}

