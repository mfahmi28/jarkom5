<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Check if user have specified Role
         * Usage : @role('role1|role2|role3') ... @else ... @endrole
         * */
        Blade::if('role', function ($roles) {
            $user = Auth::user();
            $role_array = explode('|', $roles);
            if($user && isset($user->role)){
                return in_array($user->role->slug, $role_array);
            }else{
                return false;
            }
        });
        //
    }
}
