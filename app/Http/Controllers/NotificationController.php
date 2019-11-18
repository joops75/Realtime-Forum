<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Create a new NotificationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function index() {
        return [
            'readNotifications' => NotificationResource::collection(auth()->user()->readNotifications),
            'unreadNotifications' => NotificationResource::collection(auth()->user()->unreadNotifications)
        ];
    }

    public function markAsRead(Request $request) {
        auth()->user()->notifications->where('id', $request->id)->markAsRead();

        return response('marked as read', Response::HTTP_ACCEPTED);
    }
}
