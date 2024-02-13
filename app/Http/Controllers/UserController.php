<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Traits\ErrorTextTrait;

use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    use ErrorTextTrait;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function show($id): View {
        return view('user.profile', [
            'user' => $this->userRepository->getUserById($id)
        ]);
    }

    public function registerView(): View {
        return view('user.register');
    }

    public function loginView(): View {
        return view('user.login');
    }

    public function register(Request $request) {
        $validPassword = $this->userRepository->pwLengthCheck($request->password);
        $validName = $this->userRepository->nameLengthCheck($request->name);
        $validLastName = $this->userRepository->lastNameLengthCheck($request->last_name);
        if($validPassword && $validName && $validLastName) {
            $this->userRepository->saveUser([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return redirect('/login');
        }
        return back()->withErrors([
            'password_error' => !$validPassword ? $this->getPasswordError() : '',
            'name_error' => !$validName ? $this->getNameError() : '',
            'last_name_error' => !$validLastName ? $this->getLastNameError() : '',
        ])->withInput();
    }

    public function login(Request $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $isValidAuth = Auth::attempt($credentials);

        if($isValidAuth){
            if(Auth::user()->banned_user) {
                $this->logoutShared($request);
                return redirect('/login')->withErrors([
                    'ban_message' => $this->getBannedUserError()
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect('/login')->withErrors([
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

        $user = $this->userRepository->getUserById($userId);
        $isBannedUser = $user->banned_user;
        $user->update(['banned_user' => !$isBannedUser]);
        $message = $isBannedUser ? 'desbaneado' : 'baneado';

        return back()->with('success_ban_message', $user->email . ' ha sido ' . $message . ' satisfactoriamente');
    }
}
