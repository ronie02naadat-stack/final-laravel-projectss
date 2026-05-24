<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    /**
     * Show the password change form for first-time login
     */
    public function show()
    {
        $user = auth()->user();
        
        if ($user->password_changed) {
            return redirect('/');
        }
        
        $response = response()->view('auth.change-password', ['user' => $user]);
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }

    /**
     * Update the password and mark as changed
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        if ($user->password_changed) {
            return redirect('/');
        }

        $validated = $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password']),
            'password_changed' => true,
        ]);

        // Redirect to appropriate dashboard based on user type
        if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('message', 'Password changed successfully!');
        } elseif ($user->user_type === 'teacher') {
            return redirect()->route('teacher.dashboard')
                ->with('message', 'Password changed successfully!');
        } else {
            return redirect()->route('student.dashboard')
                ->with('message', 'Password changed successfully!');
        }
    }
}
