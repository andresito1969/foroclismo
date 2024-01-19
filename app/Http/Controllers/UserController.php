<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(string $id): View {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }

    public function registerView(): View {
        return view('user.register');
    }

    public function loginView(): View {
        return view('user.login');
    }

    public function register(Request $request) {
        $user = new User([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $user->save();

        return redirect('/login');
    }

    public function login(Request $request) {

        return redirect('/');
    }
}
