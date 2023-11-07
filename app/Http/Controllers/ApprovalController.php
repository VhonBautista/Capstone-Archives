<?php

namespace App\Http\Controllers;

use App\Models\Capstone;
use App\Models\Log;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $approvals = Capstone::with('capstoneRequest')
            ->where('status', 'inactive')
            ->paginate(10);

        return view('admin.approval', [
            'user' => $request->user(),
            'approvals' => $approvals,
        ]);
    }

    
    public function approve($id)
    {
        $capstone = Capstone::with('capstoneRequest')
            ->findOrFail($id);
        $capstone->update(['status' => 'active']);
        
        // Notification
        $user = $capstone->capstoneRequest->user;

        $title = 'Congratulations!';
        $type = 'Capstone Approved';
        $message = ' Your capstone approval request for "' . $capstone->title . '" has been approved by the admin and is now ready for viewing.';
        $url = '/capstone/view/' . $capstone->id;
        $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        
        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'approved';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' just approved the capstone approval request, titled "' . $capstone->title . '".';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        $capstone->capstoneRequest->delete();
        
        return redirect()->route('admin.approval')->with(
            'message', 'The capstone approval request has been successfully approved.',
        );
    }

    public function reject($id)
    {
        $capstone = Capstone::with('capstoneRequest')
            ->findOrFail($id);

        // Notification
        $user = $capstone->capstoneRequest->user;

        $title = 'We\'re Sorry';
        $type = 'Capstone Rejected';
        $message = ' but your capstone approval request for "' . $capstone->title . '" has been rejected by the admin. Make sure the requirements are correct and try again.';
        $url = '/collections';
        $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        
        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'rejected';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' just rejected the capstone approval request, titled "' . $capstone->title . '".';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        if ($capstone->pdf_name) {
            $oldPdfPath = public_path('pdfs/' . $capstone->pdf_name);
            if (file_exists($oldPdfPath)) {
                unlink($oldPdfPath);
            }
        }
        
        $images = $capstone->images;

        foreach ($images as $image) {
            if ($image->img_path) {
                $oldImagePath = public_path($image->img_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $image->delete();
            }
        }

        $capstone->capstoneRequest->delete();
        $capstone->delete();

        return redirect()->route('admin.approval')->with(
            'message', 'The capstone approval request has been successfully rejected.',
        );
    }
}
