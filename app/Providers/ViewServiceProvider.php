<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('admin.layout.header', function ($view) {
            $notifications = Notification::where('read', false)->get();
            $notificationCount = $notifications->count();
            
            $view->with(compact('notifications', 'notificationCount'));
        });
    }
}
