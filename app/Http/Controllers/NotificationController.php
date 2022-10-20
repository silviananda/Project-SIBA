<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id, $guard)
    {
        $notifs = Auth::guard($guard)->user()->unreadNotifications;

        foreach ($notifs as $n) {
            if ($n->id == $id) {
                $n->markAsRead();
                return redirect($n->data['url']);
            }
        }
    }

    // public function show($id, $guard)
    // {
    //     $deadlines = Auth::guard($guard)->user()->showNotifications;

    //     foreach ($deadlines as $dn) {
    //         if ($dn->id == $id) {
    //             $dn->markAsRead();
    //             return redirect($dn->data['url']);
    //         }
    //     }
    // }
}
