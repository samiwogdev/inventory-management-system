<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    //clear Notification
    public function clear()
    {
        Notification::where('read', false)->update(['read' => true]);

        return back();
    }

    // public function clear()
    // {
    //     Notification::where('user_id', auth()->id())
    //         ->where('read', false)
    //         ->update(['read' => true]);

    //     return back();
    // }
}
