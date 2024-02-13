<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Traits\ErrorTextTrait;

class BannedUser
{
    use ErrorTextTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->banned_user) {
            Auth::logout();
            return redirect('login')->withErrors([
                'ban_message' => $this->getBannedUserError()
            ]);
        }
        return $next($request);
    }
}
