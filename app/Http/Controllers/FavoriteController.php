<?php

namespace App\Http\Controllers;

use App\Models\Capstone;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $type = $request->type;

        $user = auth()->user();
        $favoriteCapstones = $user->favorites();

        if ($search) {
            $favoriteCapstones->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('authors', 'like', "%{$search}%")
                    ->orWhere('year_published', 'like', "%{$search}%");
            });
        }
        
        if ($type) {
            $favoriteCapstones->where('type', $type);
        }

        $favoriteCapstones = $favoriteCapstones->paginate(12);

        return view('favorite', [
            'user' => $request->user(),
            'favorites' => $favoriteCapstones,
        ]);
    }

    public function favorite(Request $request)
    {
        $user = auth()->user();
        $capstone = Capstone::findOrFail($request->id);
        $count = $capstone->saved_count;

        $existingFavorite = Favorite::where('user_id', $user->id)
            ->where('capstone_id', $request->id)
            ->first();

        if ($existingFavorite) {
            $count -= 1;
            $capstone->update(['saved_count' => $count]);

            $existingFavorite->delete();
        } else {
            $count += 1;
            $capstone->update(['saved_count' => $count]);

            Favorite::create([
                'user_id' => $user->id,
                'capstone_id' => $request->id,
            ]);
        }
        
        return redirect()->back();
    }
}
