<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markRead(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input(key : 'id'), function ($query) use ($request) {
                return $query->where('id', $request->input(key : 'id'));
            })->markAsRead();

        return response()->noContent();
    }
}
