<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Verification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'campus_id' => [
                'required',
                'string',
                'max:10',
                'min:8',
                'regex:/^\d{2}-[A-Za-z]{2}-\d{4}$/',
            ],
        ], [
            'campus_id.regex' => 'The campus ID format is invalid. Please use the provided format.'
        ]);    

        $user = auth()->user();
        $user_id = $user->id;

        if (!$user->verification) {
            $verification = Verification::create([
                'user_id' => $user_id,
                'campus_id' => strtoupper($request->campus_id),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'verification-sent');
    }

    public function reassess(Request $request): RedirectResponse
    {
        $request->validate([
            'campus_id' => [
                'required',
                'string',
                'max:10',
                'min:8',
                'regex:/^\d{2}-[A-Za-z]{2}-\d{4}$/',
            ],
        ], [
            'campus_id.regex' => 'The campus ID format is invalid. Please use the provided format.'
        ]);    

        $user = auth()->user();

        if ($user->verification) {
            $user->verification->update([
                'status' => 'sent',
                'campus_id' => strtoupper($request->campus_id),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'verification-sent');
    }
}
