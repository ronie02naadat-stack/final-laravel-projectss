@extends('layouts.app')

@section('content')
<div style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
        <h1 style="font-size: 32px; color: #1f2937; margin: 0;">📚 Student Dashboard</h1>
        <span style="background: #dbeafe; color: #1e40af; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px;">Student Account</span>
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

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #667eea;">
        <h2 style="color: #1f2937; margin-top: 0;">📖 Your Courses</h2>
        <p style="color: #6b7280; font-size: 14px;">You can view and manage your enrolled courses here. Navigate to the <strong>Courses</strong> section from the menu to see all available courses.</p>
        <a href="/courses" style="display: inline-block; margin-top: 15px; background: #667eea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">View Courses →</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #764ba2; margin-top: 20px;">
        <h2 style="color: #1f2937; margin-top: 0;">🎓 Your Degrees</h2>
        <p style="color: #6b7280; font-size: 14px;">Track your academic progress and view degree requirements. Check the <strong>Degrees</strong> section to see your degree information.</p>
        <a href="/degrees" style="display: inline-block; margin-top: 15px; background: #764ba2; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">View Degrees →</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f5576c; margin-top: 20px;">
        <h2 style="color: #1f2937; margin-top: 0;">✍️ Your Profile</h2>
        <p style="color: #6b7280; font-size: 14px;">View and update your personal profile information. Access your account profile with details and settings.</p>
        <a href="{{ route('profile') }}" style="display: inline-block; margin-top: 15px; background: #f5576c; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">View My Profile →</a>
    </div>
</div>
@endsection
