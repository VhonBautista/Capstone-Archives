<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Notifications\NewNotification;
use Illuminate\Support\Facades\Notification;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $roles = User::with('role')
        ->where('is_admin', 1)
        ->where('is_verified', 1)
        ->whereNotIn('id', [1]);

        if ($search) {
            $roles->where(function($query) use ($search) {
                $query->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $roles = $roles->paginate(10);

        $employees = User::where('is_admin', 0)
        ->where('is_verified', 1)
        ->where('type', 'employee')
        ->whereNotIn('id', [1])
        ->orderBy('lastname')
        ->get();

        return view('admin.permission', [
            'user' => $request->user(),
            'roles' => $roles,
            'employees' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee' => 'required',
        ]);

        $user = User::findOrFail($request->employee);
        $user->update(['is_admin' => 1]);

        Role::create([
            'user_id' => $request->employee,
            'manage_request' => ($request->requests) ? 1 : 0,
            'manage_create' => ($request->capstones) ? 1 : 0,
            'manage_update' => ($request->capstones) ? 1 : 0,
            'manage_delete' => ($request->capstones) ? 1 : 0,
            'manage_approval' => ($request->approvals) ? 1 : 0,
            'manage_user' => ($request->users) ? 1 : 0,
            'manage_verification' => ($request->verifications) ? 1 : 0,
        ]);

        // Notification
        $title = 'Congratulations!';
        $type = 'Promoted to Moderator';
        $message = ' you have been promoted to the role of System Moderator, granting you access to a wider range of features.';
        $url = '/dashboard';
        $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        
        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'created';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has appointed ' . $user->firstname . ' ' . $user->lastname .  ' as a System Moderator.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);
        
        return redirect()->back()->with(
            'message', 'A new moderator was added successfully.',
        );
    }

    public function edit($id)
    {
        $role = Role::with('user')
            ->findOrFail($id);

        return response()->json($role);
    }

    public function update(Request $request)
    {
        $role = Role::with('user')
            ->findOrFail($request->permission_id);

        $role->update([
            'manage_request' => ($request->requests) ? 1 : 0,
            'manage_create' => ($request->capstones) ? 1 : 0,
            'manage_update' => ($request->capstones) ? 1 : 0,
            'manage_delete' => ($request->capstones) ? 1 : 0,
            'manage_approval' => ($request->approvals) ? 1 : 0,
            'manage_user' => ($request->users) ? 1 : 0,
            'manage_verification' => ($request->verifications) ? 1 : 0,
        ]);
        
        // Notification
        $user = $role->user;
        $title = 'The Administrator';
        $type = 'Permission Modified';
        $message = ' has adjusted your system permissions.';
        $url = '/dashboard';
        $color = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';

        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'updated';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has modified ' . $user->firstname . ' ' . $user->lastname .  '\'s permissions.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        $message = 'Permissions for ' . $role->user->firstname . ' ' . $role->user->lastname . ' was updated successfully.';

        return redirect()->back()->with(
            'message', $message,
        );
    }

    public function destroy($id)
    {
        $role = Role::with('user')
            ->findOrFail($id);
        
        $user = $role->user;
        $user->update(['is_admin' => 0]);

        // Notification
        $title = 'The Administrator';
        $type = 'Demoted';
        $message = ' has demoted you from the System Moderator role and revoked your permissions.';
        $url = '/home';
        $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';

        Notification::send($user, new NewNotification($title, $type, $message, $url, $color));

        // Log
        $user_id = auth()->user()->id;
        $actions = 'deleted';
        $details = auth()->user()->firstname . ' ' . auth()->user()->lastname . ' has demoted ' . $user->firstname . ' ' . $user->lastname .  '\'s System Moderator role and revoked their permissions.';

        Log::create([
            'user_id' => $user_id,
            'actions' => $actions,
            'details' => $details,
        ]);

        $message = $role->user->firstname . ' ' . $role->user->lastname . ' has been removed as moderator successfully.';
        
        $role->delete();
        
        return redirect()->back()->with(
            'message', $message,
        );
    }
}
