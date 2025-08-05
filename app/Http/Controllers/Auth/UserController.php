<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register()
    {
        return view('pages.auth.register');
    }
    public function handleregister(RegisterRequest $request)
    {
        $validated = $request->validated();
        $fullname = $validated['fname'] . " " . $validated['lname'];
        $user = User::create([
            "fullname" => $fullname,
            "username" => $validated['username'],
            "email" => $validated['email'],
            "password" => Hash::make($validated["password"]),
            "role" => $validated["role"],
        ]);
        Auth::login($user);
        return redirect()->route('home')->with('success', "Welcome To Event Hub Website ");
    }
    public function login()
    {
        return view("pages.auth.login");
    }
    public function handlelogin(LoginRequest $request)
    {
        $credintials = $request->validated();
        if (Auth::attempt($credintials)) {
            $request->session()->regenerate();
            return redirect()->route("home")->with('success', "Welcome To Event Hub Website ");
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with("success", "Loged out successfully");
    }
}
