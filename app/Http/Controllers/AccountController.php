<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AccountController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('account.edit-account', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            // please dont hash it
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        return redirect('/')->with('success', 'Account updated successfully');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect('/')->with('success', 'Your account has been deleted successfully');
    }

    public function userAccount(Request $request)
    {
        // Assuming you have a way to authenticate the admin
        $users = User::all();
        return view('account.user-account', compact('users'));
    }

    public function deleteUser(Request $request, $id)
    {
        // Assuming you have a way to authenticate the admin
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user-account')->with('success', 'User deleted successfully');
    }
}
