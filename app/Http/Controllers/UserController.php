<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Traits\ErrorTextTrait;

class UserController extends Controller
{
    use ErrorTextTrait;

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
        $validPassword = User::passwordLengthCheck($request->password);
        $validName = User::nameLengthCheck($request->name);
        $validLastName = User::lastNameLengthCheck($request->last_name);
        if($validPassword && $validName && $validLastName) {
            $user = new User([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $user->save();
            return redirect('/login');
        }
        return back()->withErrors([
            'password_error' => !$validPassword ? $this->getPasswordError() : '',
            'name_error' => !$validName ? $this->getNameError() : '',
            'last_name_error' => !$validLastName ? $this->getLastNameError() : '',
        ])->withInput();
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if(Auth::attempt($credentials)){
            if(Auth::user()->banned_user) {
                $this->logoutShared($request);
                return back()->withErrors([
                    'ban_message' => 'vaya parece que has sido baneado :('
                ]);
            }
            $request->session()->regenerate();
            return redirect()->intended('/');
        }


        return back()->withErrors([
            'email' => $this->getGenericError()
        ])->onlyInput('email');
    }

    private function logoutShared($request) : void {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    }

    public function logout(Request $request): RedirectResponse {

        $this->logoutShared($request);
    
        return redirect('/');
    }

    public function banUser($userId) {
        if(!Auth::user()->is_admin) {
            return redirect('/');
        }

        $user = User::findOrFail($userId);
        $user->update(['banned_user' => true]);

        return back()->with('success_ban_message', $user->email . ' ha sido baneado satisfactoriamente');
    }
}
