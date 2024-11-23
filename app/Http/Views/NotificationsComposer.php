<?php

namespace App\Http\Views;

use Illuminate\View\View;

class NotificationComposer
{
    const view = ['System.Layouts.Header.header'];

    public function compose(View $view)
    {
        $user = auth()->user();
        if(!is_null($user)){
            $view->with("Notifications",$user->notifications()->whereNot("data->type","audit")->latest()->take(10)->get());
            $view->with("CountUnRead",$user->unreadNotifications()->whereNot("data->type","audit")->count());
        }
    }
}
