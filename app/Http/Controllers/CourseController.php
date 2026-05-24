<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function index()
    {
        try {
            // Check if user is a student
            if (auth()->check() && auth()->user()->user_type === 'student') {
                // Get student record using user_account_id from users table
                $student = Student::where('user_account_id', auth()->user()->user_account_id)->first();
                
                if ($student) {
                    // Get only courses for this student with teacher and degree info
                    $courses = $student->courses()
                        ->with('teacher', 'degree')
                        ->paginate(10);
                } else {
                    $courses = collect([]);
                }
            } else {
                // For non-students (teachers, admins), show all courses
                $courses = Course::with('teacher', 'degree')->withCount('students')->paginate(10);
            }
            
            Log::info('Course list retrieved', ['count' => $courses->count()]);
            return view('courses.index', compact('courses'));
        } catch (\Exception $e) {
            Log::error('Error retrieving courses: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading courses.');
        }
    }

    public function create()
    {
        try {
            return view('courses.create');
        } catch (\Exception $e) {
            Log::error('Error loading create course form: ' . $e->getMessage());
            return redirect()->route('courses.index')->with('error', 'Error loading form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:courses,code',
                'description' => 'nullable|string|max:1000',
            ], [
                'course_name.required' => 'Course name is required.',
                'code.required' => 'Course code is required.',
                'code.unique' => 'This course code already exists.',
            ]);

            $course = Course::create($validated);
            Log::info('Course created successfully', ['course_id' => $course->id, 'course_name' => $course->course_name]);
            return redirect()->route('courses.index')->with('success', "Course '{$course->course_name}' created successfully.");
        } catch (\Exception $e) {
            Log::error('Error creating course: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating course.')->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $course = Course::with('students.degree', 'students.user')->findOrFail($id);
            Log::info('Course details viewed', ['course_id' => $course->id]);
            return view('courses.show', compact('course'));
        } catch (\Exception $e) {
            Log::error('Error viewing course: ' . $e->getMessage());
            return redirect()->route('courses.index')->with('error', 'Course not found.');
        }
    }

    public function edit(string $id)
    {
        try {
            $course = Course::findOrFail($id);
            return view('courses.edit', compact('course'));
        } catch (\Exception $e) {
            Log::error('Error loading edit course form: ' . $e->getMessage());
            return redirect()->route('courses.index')->with('error', 'Course not found.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $course = Course::findOrFail($id);
            $validated = $request->validate([
                'course_name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:courses,code,' . $id,
                'description' => 'nullable|string|max:1000',
            ]);
            $course->update($validated);
            Log::info('Course updated successfully', ['course_id' => $course->id]);
            return redirect()->route('courses.show', $id)->with('success', 'Course updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating course: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating course.')->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $course = Course::findOrFail($id);
            $courseName = $course->course_name;
            $course->delete();
            Log::info('Course deleted successfully', ['course_id' => $id]);
            return redirect()->route('courses.index')->with('success', "Course '{$courseName}' deleted successfully.");
        } catch (\Exception $e) {
            Log::error('Error deleting course: ' . $e->getMessage());
            return redirect()->route('courses.index')->with('error', 'Error deleting course.');
        }
    }

    public function byDegree()
    {
        try {
            $degrees = \App\Models\Degree::with('courses.teacher')
                ->withCount('courses')
                ->orderBy('degree_code')
                ->get();
            
            Log::info('Courses by degree retrieved', ['degree_count' => $degrees->count()]);
            return view('courses.by-degree', compact('degrees'));
        } catch (\Exception $e) {
            Log::error('Error retrieving courses by degree: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading courses.');
        }
    }

    public function maintenance()
    {
        return "Down for maintenance. Please check back later." . "<br>" . "We apologize for the inconvenience.";
    }
}
