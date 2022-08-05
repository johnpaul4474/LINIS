<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersList;

class PasswordController extends Controller
{
    public function index() {
        return view('auth.passwords.reset');
    }

    public function update(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        if($request->password != $request->password_confirmation) {
            return redirect()->route('password')->with('error', 'Passwords do not match.');
        }

        $user = UsersList::find($request->user()->id);

        if (! $user || ! \Hash::check($request->current_password, $user->password)) {
            return redirect()->route('password')->with('error', 'Incorrect Password');
        }

        $user->update([
            "password" => \Hash::make($request->password)
        ]);

        return redirect()->route('home')->with('success', 'Password changed successfully.');
    }
}
