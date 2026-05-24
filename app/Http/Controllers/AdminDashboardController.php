<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAccount;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        $user = auth()->user();
        // Using latest() ensures new raw data entries appear at the top
        $students = User::where('user_type', 'student')->latest()->paginate(15);
        $teachers = User::where('user_type', 'teacher')->latest()->paginate(15);
        
        if (request()->ajax()) {
            return response()->json([
                'students' => $students,
                'teachers' => $teachers,
                'user' => $user
            ]);
        }

        $response = response()->view('dashboards.admin', [
            'user' => $user,
            'students' => $students,
            'teachers' => $teachers,
        ]);
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }

    /**
     * Show form to add new student/teacher
     */
    public function create()
    {
        $degrees = Degree::all();
        return view('dashboards.admin-create', compact('degrees'));
    }

    /**
     * Store new student/teacher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users',
            'user_type' => 'required|in:student,teacher',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'degree_id' => 'required_if:user_type,student|nullable|exists:degrees,id',
            'student_address' => 'nullable|string|max:500',
            'student_contact' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'office_location' => 'nullable|string|max:255',
            'teacher_contact' => 'nullable|string|max:20',
        ]);

        // Combine first, middle, last names for users table
        $fullName = trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']);

        $user = User::create([
            'name' => $fullName,
            'email' => $validated['email'],
            'user_type' => $validated['user_type'],
            'password' => Hash::make($validated['password']),
            'password_changed' => false,
        ]);

        // If student, create user_account and student record and auto-enroll in degree courses
        if ($user->user_type === 'student' && isset($validated['degree_id'])) {
            // Create user_account entry (legacy table that student references)
            $userAccount = UserAccount::create([
                'username' => $validated['email'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'is_active' => 1,
            ]);

            // Store user_account_id in users table for easy lookup
            $user->update(['user_account_id' => $userAccount->id]);

            // Create student record linked to user_account
            $student = Student::create([
                'user_account_id' => $userAccount->id,
                'degree_id' => $validated['degree_id'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? '',
                'last_name' => $validated['last_name'],
                'address' => $validated['student_address'] ?? 'Not specified',
                'contact_number' => $validated['student_contact'] ?? '',
            ]);

            // Get all courses for this degree and auto-enroll student
            $degreeWithCourses = Degree::findOrFail($validated['degree_id'])->load('courses');
            if ($degreeWithCourses->courses->count() > 0) {
                $courseIds = $degreeWithCourses->courses->pluck('id')->toArray();
                $student->courses()->attach($courseIds);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Student ' . $fullName . ' added successfully! Auto-enrolled in all degree courses.');
        }

        // If teacher, create teacher record with additional information
        if ($user->user_type === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? '',
                'last_name' => $validated['last_name'],
                'specialization' => $validated['specialization'],
                'experience_years' => $validated['experience_years'] ?? 0,
                'office_location' => $validated['office_location'],
                'contact_number' => $validated['teacher_contact'],
            ]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Teacher ' . $fullName . ' added successfully!');
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'User ' . $fullName . ' added successfully!');
    }

    /**
     * Show form to edit student/teacher
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $degrees = Degree::all();
        
        // Load student relationship if exists
        $student = null;
        if ($user->user_type === 'student' && $user->user_account_id) {
            $student = Student::where('user_account_id', $user->user_account_id)->first();
        }

        return view('dashboards.admin-edit', compact('user', 'degrees', 'student'));
    }

    /**
     * Update student/teacher and sync related account data
     * NOTE: Admin cannot change passwords - only user info (name, email, degree, address, contact)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Build validation rules dynamically based on actual user type
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ];

        // Add student-specific validation if user is a student
        if ($user->user_type === 'student') {
            $rules['degree_id'] = 'required|exists:degrees,id';
            $rules['student_address'] = 'nullable|string|max:500';
            $rules['student_contact'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $user, $request) {
            // 1. Update User table (name and email only - no password)
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->save();

            // 2. Sync Student-specific data if applicable
            if ($user->user_type === 'student' && $user->user_account_id) {
                // Update Legacy UserAccount
                $userAccount = UserAccount::find($user->user_account_id);
                if ($userAccount) {
                    $userAccount->update([
                        'username' => $validated['email'],
                        'email' => $validated['email'],
                    ]);
                }

                // Update Student Record
                $student = Student::where('user_account_id', $user->user_account_id)->first();
                if ($student) {
                    $oldDegreeId = $student->degree_id;
                    
                    $student->update([
                        'first_name' => $validated['name'],
                        'degree_id' => $validated['degree_id'] ?? $student->degree_id,
                        'address' => $validated['student_address'] ?? $student->address,
                        'contact_number' => $validated['student_contact'] ?? $student->contact_number,
                    ]);

                    // If degree changed, re-sync courses
                    if ($oldDegreeId != $validated['degree_id']) {
                        $student->courses()->detach();
                        $newDegree = Degree::find($validated['degree_id']);
                        if ($newDegree && $newDegree->courses->count() > 0) {
                            $student->courses()->attach($newDegree->courses->pluck('id')->toArray());
                        }
                    }
                }
            }

            // 3. Sync Teacher-specific data if applicable
            if ($user->user_type === 'teacher') {
                $teacher = Teacher::where('user_id', $user->id)->first();
                if ($teacher) {
                    $teacher->update([
                        'first_name' => $validated['name'],
                    ]);
                }
            }
        });

        return redirect()->route('admin.dashboard')
            ->with('success', 'User updated successfully and accounts synchronized.');
    }

    /**
     * Get latest counts for real-time polling
     */
    public function getLatestCounts()
    {
        $studentCount = User::where('user_type', 'student')->count();
        $teacherCount = User::where('user_type', 'teacher')->count();
        
        return response()->json([
            'studentCount' => $studentCount,
            'teacherCount' => $teacherCount,
            'timestamp' => now()->timestamp
        ]);
    }

    /**
     * Get a single user data for real-time updates
     */
    public function getUserData($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => $user->user_type
        ]);
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'User not found.'], 404);
            }
            return back()->with('error', 'User not found.');
        }

        if ($user->user_type === 'admin') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete admin users.'], 403);
            }
            return back()->with('error', 'Cannot delete admin users.');
        }

        $userName = $user->name;
        $userType = $user->user_type;
        
        // Delete related student data if applicable
        if ($user->user_type === 'student' && $user->user_account_id) {
            // Detach all courses
            $student = Student::where('user_account_id', $user->user_account_id)->first();
            if ($student) {
                $student->courses()->detach();
                $student->delete();
            }
            
            // Delete user_account
            UserAccount::find($user->user_account_id)?->delete();
        }
        
        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $userName . ' (' . $userType . ') has been deleted.',
                'user_id' => $id,
                'user_type' => $userType
            ]);
        }

        return back()->with('success', $userName . ' has been deleted.');
    }
}
