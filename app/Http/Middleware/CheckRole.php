<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Check if user have specified Role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  String  $roles_string
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles_string = "")
    {
        $user = Auth::user();
        if ($user) {
            $role_array = explode('|', $roles_string);
            if (isset($user->role->slug)) {
                if (in_array($user->role->slug, $role_array)) {
                    return $next($request);
                }
            }

            // Back if has referer, else Redirects to home
            $referer = $request->header('referer');
            if(empty($referer)) {
                return redirect(url(RouteServiceProvider::HOME));
            } else {
                return back();
            }

        } else {
            return redirect( url("/") );
        }

    }
}
