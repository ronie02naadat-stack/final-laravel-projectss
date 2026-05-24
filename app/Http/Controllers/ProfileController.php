<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $profiles = Profile::with('student')->paginate(10);
            Log::info('Profile list retrieved', ['count' => $profiles->count()]);
            return view('profiles.index', compact('profiles'));
        } catch (\Exception $e) {
            Log::error('Error retrieving profiles: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading profiles.');
        }
    }

    public function create()
    {
        try {
            $students = Student::all();
            return view('profiles.create', compact('students'));
        } catch (\Exception $e) {
            Log::error('Error loading create profile form: ' . $e->getMessage());
            return redirect()->route('profiles.index')->with('error', 'Error loading form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id|unique:profiles,student_id',
                'bio' => 'nullable|string|max:1000',
                'location' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|string|max:500',
            ], [
                'student_id.required' => 'Please select a student.',
                'student_id.unique' => 'This student already has a profile.',
                'student_id.exists' => 'The selected student does not exist.',
            ]);

            $profile = Profile::create($validated);
            Log::info('Profile created successfully', ['profile_id' => $profile->id, 'student_id' => $profile->student_id]);
            return redirect()->route('profiles.index')->with('success', "Profile for '{$profile->student->getFullNameAttribute()}' created successfully.");
        } catch (\Exception $e) {
            Log::error('Error creating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating profile.')->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $profile = Profile::with('student')->findOrFail($id);
            Log::info('Profile details viewed', ['profile_id' => $profile->id]);
            return view('profiles.show', compact('profile'));
        } catch (\Exception $e) {
            Log::error('Error viewing profile: ' . $e->getMessage());
            return redirect()->route('profiles.index')->with('error', 'Profile not found.');
        }
    }

    public function edit(string $id)
    {
        try {
            $profile = Profile::findOrFail($id);
            $students = Student::all();
            return view('profiles.edit', compact('profile', 'students'));
        } catch (\Exception $e) {
            Log::error('Error loading edit profile form: ' . $e->getMessage());
            return redirect()->route('profiles.index')->with('error', 'Profile not found.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $profile = Profile::findOrFail($id);
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id|unique:profiles,student_id,' . $id,
                'bio' => 'nullable|string|max:1000',
                'location' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|string|max:500',
            ]);
            $profile->update($validated);
            Log::info('Profile updated successfully', ['profile_id' => $profile->id]);
            return redirect()->route('profiles.show', $id)->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating profile.')->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $profile = Profile::findOrFail($id);
            $studentName = $profile->student->getFullNameAttribute();
            $profile->delete();
            Log::info('Profile deleted successfully', ['profile_id' => $id]);
            return redirect()->route('profiles.index')->with('success', "Profile for '{$studentName}' deleted successfully.");
        } catch (\Exception $e) {
            Log::error('Error deleting profile: ' . $e->getMessage());
            return redirect()->route('profiles.index')->with('error', 'Error deleting profile.');
        }
    }
}
