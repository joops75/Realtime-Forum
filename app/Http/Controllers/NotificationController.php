<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function index() {
        return [
            'readNotifications' => auth()->user()->readNotifications,
            'unreadNotifications' => auth()->user()->unreadNotifications
        ];
    }

    public function markAsRead(Request $request) {
        auth()->user()->notifications->where('id', $request->id)->markAsRead();

        return response('marked as read', Response::HTTP_ACCEPTED);
    }
}
