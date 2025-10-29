<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        // attempt login
        if (auth()->guard()->attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function logout()
    {
        auth()->guard()->logout();
        return redirect('/');
    }

    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            // rule: (table, column)
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200'],

        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // insert $incomingFields in mysql table
        // which user is login
        $user = User::create($incomingFields);
        auth()->guard()->login($user);
        // return 'Hello from our controller';
        return redirect('/');
    }
}
