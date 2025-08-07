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
    public function update(Request $request)
    {
        $user = Auth::user(); // get the currently authenticated user

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout(); // Log out the user first

        $user->delete(); // Delete their record

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }


    public function requestSpeaker()
    {
        return $this->updateRoleRequest('speaker');
    }

    public function requestOrganizer()
    {
        return $this->updateRoleRequest('organizer');
    }

    private function updateRoleRequest($requestedRole)
    {
        $user = Auth::user();

        if ($user->role === $requestedRole) {
            return response()->json([
                'message' => "You already have the {$requestedRole} role."
            ], 400);
        }
    }
}
