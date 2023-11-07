<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $type = $request->type;

        $users = User::with('verification')
            ->whereNotIn('id', [1]);

        if ($search) {
            $users->where(function($query) use ($search) {
                $query->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($type) {
            $users->where('type', $type);
        }

        $users = $users->paginate(10);

        return view('admin.user', [
            'user' => $request->user(),
            'users' => $users,
        ]);
    }
}
