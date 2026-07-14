<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('admin.profile.index', [
            'pageTitle' => 'My Profile',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Profile']
            ],
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('admin.profile.edit', [
            'pageTitle' => 'Edit Profile',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Profile', 'url' => route('admin.profile.index')],
                ['label' => 'Edit']
            ],
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the form for changing the user's password.
     */
    public function passwordForm(): View
    {
        return view('admin.profile.password', [
            'pageTitle' => 'Change Password',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Profile', 'url' => route('admin.profile.index')],
                ['label' => 'Change Password']
            ],
        ]);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Show the form for changing the user's email.
     */
    public function emailForm(): View
    {
        return view('admin.profile.email', [
            'pageTitle' => 'Change Email',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Profile', 'url' => route('admin.profile.index')],
                ['label' => 'Change Email']
            ],
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's email with verification.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'email' => $validated['email'],
            'email_verified_at' => null, // Require re-verification
        ]);

        // Send email verification notification
        // $user->sendEmailVerificationNotification();

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Email updated successfully. Please verify your new email address.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Delete avatar if exists
        if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Logout user
        Auth::logout();

        // Delete user account
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Your account has been deleted successfully.');
    }
}