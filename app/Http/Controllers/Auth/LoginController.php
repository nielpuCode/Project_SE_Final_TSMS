<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReminder;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('account.login-account');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the user by their email address
        $user = User::where('email', $credentials['email'])->first();

        // Check if the user exists and the password matches
        if ($user && $user->password === $credentials['password']) {
            // Log in the user
            Auth::login($user);

            // Regenerate the session
            $request->session()->regenerate();

            return redirect()->intended('/compComponents');
        }

        // If the user does not exist or the password does not match, redirect back with an error message
        return redirect('login')->with('error', 'Invalid credentials. Please try again.');
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return redirect()->back()->with('error', 'Email not found');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email not found');
        }

        // Send the user's password to their email
        Mail::to($user->email)->send(new PasswordReminder($user->password));

        return redirect()->back()->with('success', 'Password sent to your email');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/compComponents');
    }
}
