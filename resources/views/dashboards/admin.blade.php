@extends('layouts.app')

@section('content')
<div data-admin-dashboard data-student-total="{{ $students->total() }}" data-teacher-total="{{ $teachers->total() }}" data-latest-counts-url="{{ route('admin.latest-counts') }}" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
        <h1 style="font-size: 32px; color: #1f2937; margin: 0;">👨‍💼 Admin Dashboard</h1>
        <span style="background: #fee2e2; color: #991b1b; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px;">Admin Account</span>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444;">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin-bottom: 10px;">Your Name</div>
            <div style="font-size: 24px; font-weight: bold;">{{ $user->name }}</div>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin-bottom: 10px;">Email</div>
            <div style="font-size: 18px; font-weight: bold; word-break: break-all;">{{ $user->email }}</div>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <div style="font-size: 12px; text-transform: uppercase; opacity: 0.9; margin-bottom: 10px;">Member Since</div>
            <div style="font-size: 20px; font-weight: bold;">{{ $user->created_at->format('M d, Y') }}</div>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ef4444; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <h2 style="color: #1f2937; margin: 0;">➕ Add Student / Teacher</h2>
            <a href="{{ route('admin.create') }}" style="background: #ef4444; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">+ Add User</a>
        </div>
        <p style="color: #6b7280; font-size: 14px; margin: 0;">Click the button above to add a new student or teacher to the system.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Students Section -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h2 style="color: #1f2937; margin-top: 0;">👨‍🎓 Students ({{ $students->total() }})</h2>
            
            @if($students->count())
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 12px; text-align: left; color: #667eea; font-weight: 600;">Name</th>
                                <th style="padding: 12px; text-align: left; color: #667eea; font-weight: 600;">Email</th>
                                <th style="padding: 12px; text-align: center; color: #667eea; font-weight: 600;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr style="border-bottom: 1px solid #e5e7eb;" data-student-id="{{ $student->id }}">
                                    <td style="padding: 12px;">{{ $student->name }}</td>
                                    <td style="padding: 12px; color: #6b7280; word-break: break-all;">{{ $student->email }}</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <a href="{{ route('admin.edit', $student->id) }}" style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; transition: background 0.3s; display: inline-block; margin-right: 5px;">Edit</a>
                                        <button class="delete-btn" data-type="student" data-id="{{ $student->id }}" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 12px; transition: background 0.3s;">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($students->hasPages())
                    <div style="margin-top: 15px; display: flex; justify-content: center;">
                        {{ $students->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @else
                <p style="color: #9ca3af; text-align: center; padding: 40px 0;">No students found.</p>
            @endif
        </div>

        <!-- Teachers Section -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h2 style="color: #1f2937; margin-top: 0;">👨‍🏫 Teachers ({{ $teachers->total() }})</h2>
            <div style="display: none; background: #f0f0f0; padding: 10px; margin-bottom: 10px; font-family: monospace; font-size: 12px; color: #666;">
                DEBUG: teachers->count()={{ $teachers->count() }}, teachers->total()={{ $teachers->total() }}, isset($teachers)={{ isset($teachers) ? 'true' : 'false' }}
            </div>
            
            @if($teachers->count() > 0 || true)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 12px; text-align: left; color: #10b981; font-weight: 600;">Name</th>
                                <th style="padding: 12px; text-align: left; color: #10b981; font-weight: 600;">Email</th>
                                <th style="padding: 12px; text-align: center; color: #10b981; font-weight: 600;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr style="border-bottom: 1px solid #e5e7eb;" data-teacher-id="{{ $teacher->id }}">
                                    <td style="padding: 12px;">{{ $teacher->name }}</td>
                                    <td style="padding: 12px; color: #6b7280; word-break: break-all;">{{ $teacher->email }}</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <a href="{{ route('admin.edit', $teacher->id) }}" style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; transition: background 0.3s; display: inline-block; margin-right: 5px;">Edit</a>
                                        <button class="delete-btn" data-type="teacher" data-id="{{ $teacher->id }}" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 12px; transition: background 0.3s;">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="padding: 20px; text-align: center; color: #9ca3af;">No teachers found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($teachers->hasPages())
                    <div style="margin-top: 15px; display: flex; justify-content: center;">
                        {{ $teachers->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
