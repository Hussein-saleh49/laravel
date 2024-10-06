<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public $test = "TEST";

    public function login() {
        // TODO view to redirect to login page
        return view('auth.login');
    }

    public function loginAction(Request $request) {
        // TODO view to redirect to login page
        $validated = $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => ['required', 'min:6', 'alpha_num']
        ]);

        $admin = User::where('email', $validated['email'])->first();
        if (Hash::check($validated['password'], $admin->password)) {
            Auth::login($admin);
            return redirect()->route('index');
        }
        return back()->withInput($validated)
            ->withErrors(['password' => 'Password is wrong']);
    }

    public function register() {
        // TODO view to redirect to register page
        return view('auth.register');
    }

    public function registerAction(RegisterRequest $request) {
        // TODO view to redirect to register page
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $admin = User::create($request->validated());
        auth()->login($admin);
        return redirect()->route('index');
    }

    public function logout() {
        // TODO view to redirect to login page after logout
        auth()->logout();
        return redirect()->route('login');
    }

}
