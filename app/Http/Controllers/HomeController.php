<?php

namespace App\Http\Controllers;

use App\Models\Capstone;
use App\Models\Verification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $type = $request->type;

        $capstones = Capstone::with('images')
            ->where('status', 'active');

        if ($search) {
            $capstones->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('authors', 'like', "%{$search}%")
                    ->orWhere('year_published', 'like', "%{$search}%");
            });
        }
        
        if ($type) {
            $capstones->where('type', $type);
        }

        $capstones = $capstones->paginate(12);

        return view('home', [
            'user' => $request->user(),
            'capstones' => $capstones,
        ]);
    }

    public function admin(Request $request)
    {
        return view('admin.dashboard', [
            'user' => $request->user(),
        ]);
    }
}
