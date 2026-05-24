<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $degrees = Degree::withCount('students', 'courses')->paginate(2);
            Log::info('Degree list retrieved', ['count' => $degrees->count()]);
            return view('degrees.index', compact('degrees'));
        } catch (\Exception $e) {
            Log::error('Error retrieving degree list: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading degrees.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('degrees.create');
        } catch (\Exception $e) {
            Log::error('Error loading create degree form: ' . $e->getMessage());
            return redirect()->route('degrees.index')->with('error', 'Error loading form.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'degree_title' => 'required|string|max:255|unique:degrees,degree_title|regex:/^[a-zA-Z0-9\s\-\.]+$/',
            ], [
                'degree_title.required' => 'The degree title field is required.',
                'degree_title.unique' => 'This degree title already exists.',
                'degree_title.regex' => 'The degree title must contain only letters, numbers, spaces, hyphens, and dots.',
                'degree_title.max' => 'The degree title must not exceed 255 characters.',
            ]);

            $degree = Degree::create($validated);
            
            Log::info('Degree created successfully', [
                'degree_id' => $degree->id,
                'degree_title' => $degree->degree_title,
                'created_by_ip' => $request->ip()
            ]);

            return redirect()->route('degrees.index')
                            ->with('success', "Degree '{$degree->degree_title}' created successfully.");
        } catch (ValidationException $e) {
            Log::warning('Degree creation validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating degree: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Error creating degree. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $degree = Degree::with('students', 'courses.teacher')->findOrFail($id);
            
            // Get courses for this degree
            $courses = $degree->courses()->with('teacher')->get();
            
            Log::info('Degree details viewed', ['degree_id' => $degree->id, 'degree_title' => $degree->degree_title]);
            return view('degrees.show', compact('degree', 'courses'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Degree not found', ['degree_id' => $id]);
            return redirect()->route('degrees.index')->with('error', 'Degree not found.');
        } catch (\Exception $e) {
            Log::error('Error viewing degree: ' . $e->getMessage());
            return redirect()->route('degrees.index')->with('error', 'Error loading degree details.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $degree = Degree::findOrFail($id);
            return view('degrees.edit', compact('degree'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Degree not found for edit', ['degree_id' => $id]);
            return redirect()->route('degrees.index')->with('error', 'Degree not found.');
        } catch (\Exception $e) {
            Log::error('Error loading edit degree form: ' . $e->getMessage());
            return redirect()->route('degrees.index')->with('error', 'Error loading form.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $degree = Degree::findOrFail($id);
            
            $validated = $request->validate([
                'degree_title' => 'required|string|max:255|unique:degrees,degree_title,' . $id . '|regex:/^[a-zA-Z0-9\s\-\.]+$/',
            ], [
                'degree_title.required' => 'The degree title field is required.',
                'degree_title.unique' => 'This degree title already exists.',
                'degree_title.regex' => 'The degree title must contain only letters, numbers, spaces, hyphens, and dots.',
                'degree_title.max' => 'The degree title must not exceed 255 characters.',
            ]);

            $oldTitle = $degree->degree_title;
            $degree->update($validated);
            
            Log::info('Degree updated successfully', [
                'degree_id' => $degree->id,
                'old_title' => $oldTitle,
                'new_title' => $degree->degree_title
            ]);

            return redirect()->route('degrees.show', $degree->id)
                            ->with('success', "Degree '{$degree->degree_title}' updated successfully.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Degree not found for update', ['degree_id' => $id]);
            return redirect()->route('degrees.index')->with('error', 'Degree not found.');
        } catch (ValidationException $e) {
            Log::warning('Degree update validation failed', ['degree_id' => $id, 'errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating degree: ' . $e->getMessage(), ['degree_id' => $id, 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Error updating degree. Please try again.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $degree = Degree::findOrFail($id);
            $degreeTitle = $degree->degree_title;
            $studentCount = $degree->students()->count();
            
            if ($studentCount > 0) {
                Log::warning('Attempted to delete degree with associated students', [
                    'degree_id' => $id,
                    'degree_title' => $degreeTitle,
                    'student_count' => $studentCount
                ]);
                return redirect()->route('degrees.index')
                                ->with('warning', "Cannot delete '{$degreeTitle}'. It has {$studentCount} student(s) enrolled.");
            }
            
            $degree->delete();
            
            Log::info('Degree deleted successfully', [
                'degree_id' => $id,
                'degree_title' => $degreeTitle
            ]);

            return redirect()->route('degrees.index')
                            ->with('success', "Degree '{$degreeTitle}' deleted successfully.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Degree not found for deletion', ['degree_id' => $id]);
            return redirect()->route('degrees.index')->with('error', 'Degree not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting degree: ' . $e->getMessage(), ['degree_id' => $id, 'trace' => $e->getTraceAsString()]);
            return redirect()->route('degrees.index')->with('error', 'Error deleting degree. Please try again.');
        }
    }
}
