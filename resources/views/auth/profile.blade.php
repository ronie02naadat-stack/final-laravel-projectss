@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>👤 My Profile</h1>
            <p class="text-muted">Manage your account settings and change your password</p>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- User Info Card -->
    <div class="card mb-4" style="border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="card-title" style="color: #667eea; font-weight: 700; margin-bottom: 20px;">Account Information</h5>
                    <div style="margin-top: 20px;">
                        <!-- Common Fields -->
                        <div style="margin-bottom: 15px;">
                            <small style="color: #667eea; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Full Name</small>
                            <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $user->name }}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <small style="color: #667eea; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</small>
                            <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $user->email }}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <small style="color: #667eea; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Account Type</small>
                            <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">
                                @if($user->user_type === 'student')
                                    <span class="badge bg-info">👨‍🎓 Student</span>
                                @elseif($user->user_type === 'teacher')
                                    <span class="badge bg-success">👨‍🏫 Teacher</span>
                                @elseif($user->user_type === 'admin')
                                    <span class="badge bg-danger">👨‍💼 Admin</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <small style="color: #667eea; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Member Since</small>
                            <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $user->created_at->format('F d, Y') }}</p>
                        </div>

                        <!-- Student-Specific Information -->
                        @if($user->user_type === 'student' && isset($student))
                            <hr style="margin: 20px 0;">
                            <h6 style="color: #10b981; font-weight: 700; margin-bottom: 15px;">📚 Student Information</h6>
                            @if($student)
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">First Name</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $student->first_name }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Middle Name</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $student->middle_name ?: 'N/A' }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Last Name</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $student->last_name }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Degree Program</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">
                                        @if($student->degree)
                                            {{ $student->degree->degree_title }} ({{ $student->degree->degree_code }})
                                        @else
                                            Not assigned
                                        @endif
                                    </p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Address</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $student->address ?: 'Not provided' }}</p>
                                </div>
                                <div>
                                    <small style="color: #10b981; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Contact Number</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $student->contact_number ?: 'Not provided' }}</p>
                                </div>
                            @else
                                <p class="text-muted">Student information not found.</p>
                            @endif
                        @endif

                        <!-- Teacher-Specific Information -->
                        @if($user->user_type === 'teacher' && isset($teacher))
                            <hr style="margin: 20px 0;">
                            <h6 style="color: #f59e0b; font-weight: 700; margin-bottom: 15px;">🎓 Teacher Information</h6>
                            @if($teacher)
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">First Name</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->first_name }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Middle Name</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->middle_name ?: 'N/A' }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Last Name</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->last_name }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Specialization</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->specialization ?: 'Not specified' }}</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Years of Experience</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->experience_years }} years</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Office Location</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->office_location ?: 'Not provided' }}</p>
                                </div>
                                <div>
                                    <small style="color: #f59e0b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Contact Number</small>
                                    <p style="margin: 5px 0 0 0; color: #111827; font-size: 16px;">{{ $teacher->contact_number ?: 'Not provided' }}</p>
                                </div>
                            @else
                                <p class="text-muted">Teacher information not found.</p>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; font-size: 40px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div style="margin-top: 15px; font-weight: 600; color: #667eea;">
                        @if($user->user_type === 'student')
                            👨‍🎓 Student
                        @elseif($user->user_type === 'teacher')
                            👨‍🏫 Teacher
                        @elseif($user->user_type === 'admin')
                            👨‍💼 Admin
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Card -->
    <div class="card" style="border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div class="card-body">
            <h5 class="card-title" style="color: #667eea; font-weight: 700; margin-bottom: 20px;">🔐 Change Password</h5>

            <form action="{{ route('password.update') }}" method="POST" id="passwordForm">
                @csrf

                <!-- Step 1: Confirm Current Password -->
                <div id="step1" class="password-step">
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input 
                            type="password" 
                            class="form-control @error('current_password') is-invalid @enderror" 
                            id="current_password" 
                            name="current_password" 
                            placeholder="Enter your current password"
                            required>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="button" class="btn btn-primary" id="confirmBtn" onclick="confirmPassword()">
                        ✓ Confirm Password
                    </button>
                </div>

                <!-- Step 2: New Password (Hidden initially) -->
                <div id="step2" class="password-step" style="display: none; border-top: 2px solid #e5e7eb; padding-top: 20px; margin-top: 20px;">
                    <div style="background: #f0f7ff; border-left: 4px solid #667eea; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                        <small style="color: #667eea; font-weight: 600;">
                            ✓ Password confirmed! Now enter your new password below.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password</label>
                        <input 
                            type="password" 
                            class="form-control @error('new_password') is-invalid @enderror" 
                            id="new_password" 
                            name="new_password" 
                            placeholder="Enter your new password (minimum 8 characters)"
                            required>
                        @error('new_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            placeholder="Confirm your new password"
                            required>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-success">
                            🔄 Update Password
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            ✕ Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #667eea;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
        background: #10b981;
        border: none;
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 10px;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6b7280;
        border: none;
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 10px;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #dc3545;
        border: none;
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 10px;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }
</style>

<script>
    function confirmPassword() {
        // Validate that current password field is filled
        const currentPassword = document.getElementById('current_password').value;
        if (!currentPassword) {
            alert('Please enter your current password');
            return;
        }

        // Show loading state
        const confirmBtn = document.getElementById('confirmBtn');
        const originalText = confirmBtn.innerHTML;
        confirmBtn.innerHTML = '⏳ Verifying...';
        confirmBtn.disabled = true;

        // Make AJAX request to verify password
        fetch('{{ route("password.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                current_password: currentPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show step 2
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
            } else {
                // Show error
                alert(data.message || 'Incorrect password. Please try again.');
                confirmBtn.innerHTML = originalText;
                confirmBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            confirmBtn.innerHTML = originalText;
            confirmBtn.disabled = false;
        });
    }

    function resetForm() {
        // Hide step 2 and show step 1 again
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step1').style.display = 'block';
        document.getElementById('current_password').value = '';
        document.getElementById('new_password').value = '';
        document.getElementById('new_password_confirmation').value = '';
        document.getElementById('confirmBtn').disabled = false;
        document.getElementById('confirmBtn').innerHTML = '✓ Confirm Password';
    }

    // If there are errors, show step 2
    document.addEventListener('DOMContentLoaded', function() {
        const errors = document.querySelectorAll('.invalid-feedback');
        if (errors.length > 0) {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        }
    });
</script>
@endsection
