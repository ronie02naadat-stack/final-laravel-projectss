@extends('layouts.app')

@section('content')
<div style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
        <h1 style="font-size: 32px; color: #1f2937; margin: 0;">👨‍🏫 Teacher Dashboard</h1>
        <span style="background: #d1fae5; color: #065f46; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px;">Teacher Account</span>
    </div>

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

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #10b981;">
        <h2 style="color: #1f2937; margin-top: 0;">📚 Manage Courses</h2>
        <p style="color: #6b7280; font-size: 14px;">Create, edit, and manage courses for your students. View all available courses and their details.</p>
        <a href="/courses" style="display: inline-block; margin-top: 15px; background: #10b981; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">View Courses →</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b; margin-top: 20px;">
        <h2 style="color: #1f2937; margin-top: 0;">👥 Students</h2>
        <p style="color: #6b7280; font-size: 14px;">View student information and manage enrollment for your courses. Access the <strong>Students</strong> section for more details.</p>
        <a href="/students" style="display: inline-block; margin-top: 15px; background: #f59e0b; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">View Students →</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #8b5cf6; margin-top: 20px;">
        <h2 style="color: #1f2937; margin-top: 0;">📝 Activity & Posts</h2>
        <p style="color: #6b7280; font-size: 14px;">Share announcements and important updates with your students. Create posts and manage class activities.</p>
        <a href="/posts" style="display: inline-block; margin-top: 15px; background: #8b5cf6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">View Posts →</a>
    </div>
</div>
@endsection
