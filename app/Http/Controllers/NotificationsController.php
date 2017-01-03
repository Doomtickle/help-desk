<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function readAll()
    {
        foreach(\Auth::user()->unreadNotifications as $n){
            $n->markAsRead();
        }

        return back();
        
    }
    
}
