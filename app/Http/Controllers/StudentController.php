<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Degree;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $students = Student::with('degree')->paginate(2);
            Log::info('Student list retrieved', ['count' => $students->count()]);
            return view('students.index', compact('students'));
        } catch (\Exception $e) {
            Log::error('Error retrieving student list: ' . $e->getMessage());
            return redirect()->route('students.index')->with('error', 'Error loading students.');
        }
    }

    // Note: create(), store(), edit(), update(), and destroy() methods removed.
    // All student management is now handled via AdminDashboardController with AJAX.

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            Log::info('Student details viewed', ['student_id' => $student->id, 'student_email' => $student->email]);
            return view('students.show', compact('student'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Student not found', ['student_id' => $id]);
            return redirect()->route('students.index')->with('error', 'Student not found.');
        } catch (\Exception $e) {
            Log::error('Error viewing student: ' . $e->getMessage());
            return redirect()->route('students.index')->with('error', 'Error loading student details.');
        }
    }
}
