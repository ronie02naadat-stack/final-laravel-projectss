<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin(Request $request)
    {
        // Clear throttle if time has expired
        $throttleUntil = $request->session()->get('throttle_until');
        if ($throttleUntil && now() >= $throttleUntil) {
            $request->session()->forget('login_attempts');
            $request->session()->forget('throttle_until');
        }

        $response = response()->view('auth.login');
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        $response = response()->view('auth.register');
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Track failed attempts in session FIRST
        $attempts = $request->session()->get('login_attempts', 0);

        // Check if currently throttled (after 2 failed attempts)
        if ($attempts >= 2) {
            $throttleUntil = $request->session()->get('throttle_until');
            if ($throttleUntil && now() < $throttleUntil) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Too many login attempts. Please wait before trying again.',
                    ]);
            }
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->forget('login_attempts');
            $request->session()->forget('throttle_until');
            
            $user = auth()->user();
            
            // Check if user needs to change password on first login
            if (!$user->password_changed) {
                return redirect()->route('password.change.show');
            }
            
            // Redirect to appropriate dashboard based on user type
            if ($user->user_type === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->user_type === 'teacher') {
                return redirect()->route('teacher.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }
        }

        // Increment failed attempts
        $attempts++;
        $request->session()->put('login_attempts', $attempts);
        
        // After 2 failed attempts (on 3rd attempt onwards), set throttle time
        if ($attempts > 2) {
            $request->session()->put('throttle_until', now()->addSeconds(10));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'user_type' => 'required|in:student,teacher',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'user_type' => $validated['user_type'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Redirect to appropriate dashboard based on user type
        if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->user_type === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }

    /**
     * Show user profile page
     */
    public function showProfile()
    {
        $user = Auth::user();
        $data = ['user' => $user];
        
        // Load role-specific information
        if ($user->user_type === 'student') {
            $student = \App\Models\Student::where('user_account_id', $user->user_account_id)->first();
            $data['student'] = $student;
        } elseif ($user->user_type === 'teacher') {
            $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();
            $data['teacher'] = $teacher;
        }
        
        $response = response()->view('auth.profile', $data);
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }

    /**
     * Verify current password via AJAX
     */
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The current password is incorrect.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password verified successfully!',
        ]);
    }

    /**
     * Update user password after confirming current password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
