<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('account.register-account');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        if ($user) {
            // Registration success
            $request->session()->flash('success', 'Registration successful!');
        } else {
            // Registration failed
            $request->session()->flash('error', 'Registration failed. Please try again.');
        }

        Auth::login($user);

        return redirect()->intended('/compComponents');
    }
}
