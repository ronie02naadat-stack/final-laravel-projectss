@extends('layouts.app')

@section('content')
<div style="padding: 40px 20px; max-width: 600px; margin: 0 auto;">
    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h1 style="font-size: 28px; color: #1f2937; margin-top: 0;">➕ Add User</h1>
        <p style="color: #6b7280; margin-bottom: 30px;">Create a new student or teacher account.</p>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
                <strong>❌ Validation Errors:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.store') }}" style="display: flex; flex-direction: column;">
            @csrf

            <!-- User Type Selection -->
            <div style="margin-bottom: 20px;">
                <label for="user_type" style="display: block; font-size: 13px; font-weight: 700; color: #667eea; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Account Type</label>
                <select 
                    id="user_type"
                    name="user_type" 
                    style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: #f9fafb; box-sizing: border-box;"
                    required>
                    <option value="">-- Select Account Type --</option>
                    <option value="student" {{ old('user_type') === 'student' ? 'selected' : '' }}>👨‍🎓 Student</option>
                    <option value="teacher" {{ old('user_type') === 'teacher' ? 'selected' : '' }}>👨‍🏫 Teacher</option>
                </select>
            </div>

            <!-- Email Address -->
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-size: 13px; font-weight: 700; color: #667eea; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Email Address</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="Enter email address"
                    style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: #f9fafb; box-sizing: border-box;"
                    required>
            </div>

            <!-- Name Fields Section -->
            <div style="background: #f0f4ff; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #667eea;">
                <h3 style="margin-top: 0; font-size: 14px; color: #667eea; font-weight: 600;">📋 Name Information</h3>
                
                <div style="margin-bottom: 15px;">
                    <label for="first_name" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">First Name</label>
                    <input 
                        type="text" 
                        id="first_name"
                        name="first_name" 
                        value="{{ old('first_name') }}"
                        placeholder="Enter first name"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;"
                        required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="middle_name" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Middle Name (Optional)</label>
                    <input 
                        type="text" 
                        id="middle_name"
                        name="middle_name" 
                        value="{{ old('middle_name') }}"
                        placeholder="Enter middle name"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                </div>

                <div>
                    <label for="last_name" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Last Name</label>
                    <input 
                        type="text" 
                        id="last_name"
                        name="last_name" 
                        value="{{ old('last_name') }}"
                        placeholder="Enter last name"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;"
                        required>
                </div>
            </div>

            <!-- Student-Specific Fields -->
            <div id="student-section" style="display: none;">
                <div style="background: #f0fdf4; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #10b981;">
                    <h3 style="margin-top: 0; font-size: 14px; color: #10b981; font-weight: 600;">👨‍🎓 Student Information</h3>

                    <div style="margin-bottom: 15px;">
                        <label for="degree_id" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Degree Program <span style="color: #ef4444;">*</span></label>
                        <select 
                            id="degree_id"
                            name="degree_id"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                            <option value="">-- Select a Degree --</option>
                            @foreach($degrees ?? [] as $degree)
                                <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                                    {{ $degree->degree_title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="student_address" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Address</label>
                        <textarea 
                            id="student_address"
                            name="student_address" 
                            placeholder="Enter street address, city, province"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box; resize: vertical; min-height: 80px;"
                        >{{ old('student_address') }}</textarea>
                    </div>

                    <div>
                        <label for="student_contact" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Contact Number</label>
                        <input 
                            type="tel" 
                            id="student_contact"
                            name="student_contact" 
                            value="{{ old('student_contact') }}"
                            placeholder="e.g., +63 9XX XXX XXXX"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                    </div>
                </div>
            </div>

            <!-- Teacher-Specific Fields -->
            <div id="teacher-section" style="display: none;">
                <div style="background: #fef3c7; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">
                    <h3 style="margin-top: 0; font-size: 14px; color: #b45309; font-weight: 600;">👨‍🏫 Teacher Information</h3>

                    <div style="margin-bottom: 15px;">
                        <label for="specialization" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Subject/Specialization</label>
                        <input 
                            type="text" 
                            id="specialization"
                            name="specialization" 
                            value="{{ old('specialization') }}"
                            placeholder="e.g., Mathematics, Computer Science, Physics"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="experience_years" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Years of Experience</label>
                        <input 
                            type="number" 
                            id="experience_years"
                            name="experience_years" 
                            value="{{ old('experience_years', 0) }}"
                            min="0"
                            max="50"
                            placeholder="0"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="office_location" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Office Location</label>
                        <input 
                            type="text" 
                            id="office_location"
                            name="office_location" 
                            value="{{ old('office_location') }}"
                            placeholder="e.g., Building A, Room 205"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                    </div>

                    <div>
                        <label for="teacher_contact" style="display: block; font-size: 13px; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Contact Number</label>
                        <input 
                            type="tel" 
                            id="teacher_contact"
                            name="teacher_contact" 
                            value="{{ old('teacher_contact') }}"
                            placeholder="e.g., +63 9XX XXX XXXX"
                            style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: white; box-sizing: border-box;">
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-size: 13px; font-weight: 700; color: #667eea; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Password <span style="color: #ef4444;">*</span></label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Minimum 8 characters"
                    style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; color: #111827; transition: all 0.3s ease; background: #f9fafb; box-sizing: border-box;"
                    required>
                <small style="color: #6b7280; font-size: 12px; margin-top: 5px; display: block;">Password must be at least 8 characters long</small>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" style="flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">✅ Create User</button>
                <a href="{{ route('admin.dashboard') }}" style="flex: 1; background: #e5e7eb; color: #111827; padding: 14px 24px; border-radius: 10px; font-size: 16px; font-weight: 600; text-decoration: none; text-align: center; transition: all 0.3s ease;">Cancel</a>
            </div>
        </form>

        <script>
            const userTypeSelect = document.getElementById('user_type');
            const studentSection = document.getElementById('student-section');
            const teacherSection = document.getElementById('teacher-section');
            const degreeInput = document.getElementById('degree_id');

            function toggleSections() {
                if (userTypeSelect.value === 'student') {
                    studentSection.style.display = 'block';
                    teacherSection.style.display = 'none';
                    degreeInput.required = true;
                } else if (userTypeSelect.value === 'teacher') {
                    studentSection.style.display = 'none';
                    teacherSection.style.display = 'block';
                    degreeInput.required = false;
                } else {
                    studentSection.style.display = 'none';
                    teacherSection.style.display = 'none';
                    degreeInput.required = false;
                }
            }

            userTypeSelect.addEventListener('change', toggleSections);
            
            // Trigger on page load if student or teacher is already selected
            if (userTypeSelect.value) {
                toggleSections();
            }
        </script>
    </div>
</div>
@endsection
