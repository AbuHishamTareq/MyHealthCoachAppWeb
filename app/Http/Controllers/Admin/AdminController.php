<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function show() {
        return view('admin.auth.login');
    }

    public function login(AdminRequest $request) {
        if (Auth::guard('admin')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 1
        ])) {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('auth.login.show')->with([
                'error' => 'Invalid email address or password. Please check with Adminstrator if your account is active !'
            ]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('auth.login.show')->with([
            'success' => 'Logged out successfully !'
        ]);
    }
}
