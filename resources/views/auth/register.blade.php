<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RFN Project</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
            overflow: hidden;
            animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }

        .logo-icon svg {
            width: 40px;
            height: 40px;
        }

        .register-title {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .register-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
        }

        .register-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            color: #111827;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input::-webkit-scrollbar {
            width: 8px;
        }

        .form-input::-webkit-scrollbar-track {
            background: #e5e7eb;
        }

        .form-input::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 4px;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideIn 0.4s ease;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        .register-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .register-footer {
            padding: 20px 40px;
            text-align: center;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .register-footer-text {
            font-size: 14px;
            color: #6b7280;
        }

        .register-footer-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-footer-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-header {
                padding: 30px 24px;
            }

            .register-body {
                padding: 30px 24px;
            }

            .register-footer {
                padding: 16px 24px;
            }

            .register-title {
                font-size: 24px;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
            }

            .logo-icon svg {
                width: 35px;
                height: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h1 class="register-title">Create Account</h1>
                <p class="register-subtitle">Join us today</p>
            </div>

            <div class="register-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input 
                            type="text" 
                            class="form-input @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            placeholder="Enter your full name"
                            value="{{ old('name') }}"
                            required
                            autofocus>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            class="form-input @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="Enter your email address"
                            value="{{ old('email') }}"
                            required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            class="form-input @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Enter a strong password"
                            required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input 
                            type="password" 
                            class="form-input" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Confirm your password"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="user_type" class="form-label">Account Type</label>
                        <select 
                            class="form-input @error('user_type') is-invalid @enderror" 
                            id="user_type" 
                            name="user_type" 
                            required>
                            <option value="">-- Select Account Type --</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                        @error('user_type')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="register-button">Create Account</button>
                </form>
            </div>

            <div class="register-footer">
                <p class="register-footer-text">
                    Already have an account? <a href="{{ route('login') }}" class="register-footer-link">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
