<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Verification;
use App\Models\Log;
use App\Notifications\NewNotification;
use Illuminate\Support\Facades\Notification;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $verifications = User::with('verification')
            ->whereHas('verification', function($query) {
                $query->where('status', 'sent');
            })
            ->paginate(10);

        return view('admin.verification', [
            'user' => $request->user(),
            'verifications' => $verifications,
        ]);
    }

    public function accept($id)
    {
        $verification = Verification::findOrFail($id);
        $verification->update(['status' => 'verified']);
        
        $user = User::findOrFail($verification->user_id);
        $user->update(['is_verified' => 1]);
        
        // Notification
        $title = $verification->campus_id;
        $type = ucfirst($user->type) . ' ID Verified';
        $message = ' has now been verified and grants you access to additional features and functionalities.';
        $url = '/settings';
        $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        
        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'verified';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' just verified the ' . $user->type . ' ID number (' . $verification->campus_id .  ') of ' . $user->firstname . ' ' . $user->lastname . '.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        return redirect()->back()->with(
            'message', 'Verification request was accepted successfully.',
        );
    }

    public function reject($id)
    {
        $verification = Verification::findOrFail($id);
        $verification->update(['status' => 'rejected']);

        // Notification
        $user = User::findOrFail($verification->user_id);
        $title = $verification->campus_id;
        $type = 'Verification Rejected';
        $message = ' is NOT a valid Pangasinan State University ID or does not currently exist.';
        $url = '/settings';
        $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        
        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'rejected';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' just rejected the ' . $user->type . ' ID number (' . $verification->campus_id .  ') of ' . $user->firstname . ' ' . $user->lastname . '.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        return redirect()->back()->with(
            'message', 'Verification request was rejected successfully.',
        );
    }
}
