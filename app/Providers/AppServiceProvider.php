<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Schema;
use App\Notifications\AccountVerificationNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;

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
        Schema::defaultStringLength(191);

        AccountVerificationNotification::createUrlUsing(function ($notifiable, $route){
            $prefix = explode('.', $route);
            $neededRoute = sprintf('%s.verification.verify', in_array($prefix[0], ['admin']) ? $prefix[0] :'');
             return URL::temporarySignedRoute(
                 trim($neededRoute, '.'),
                 Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
                 'id'    => $notifiable->getKey(),
                 'hash' => sha1($notifiable->getEmailForVerification())
             ]);
         });
 
         ResetPasswordNotification::createUrlUsing(function ($user, $token, $route){
            return $route === 'admin.password.email'
              ? route('admin.password.reset', ['token' => $token, 'email' => $user->email])
              : route('password.reset' , ['token' => $token, 'email' => $user->email]);
         });
    }
}
