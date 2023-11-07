<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Log::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.log', [
            'user' => $request->user(),
            'logs' => $logs,
        ]);
    }
}
