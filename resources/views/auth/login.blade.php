<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RFN Project</title>
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

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
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

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
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

        .login-title {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .login-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
        }

        .login-body {
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

        .login-button {
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

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-footer {
            padding: 20px 40px;
            text-align: center;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .login-footer-text {
            font-size: 14px;
            color: #6b7280;
        }

        .login-footer-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-footer-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .remember-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .remember-checkbox label {
            margin-left: 8px;
            font-size: 14px;
            color: #4b5563;
            cursor: pointer;
        }

        @media (max-width: 480px) {
            .login-header {
                padding: 30px 24px;
            }

            .login-body {
                padding: 30px 24px;
            }

            .login-footer {
                padding: 16px 24px;
            }

            .login-title {
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
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to your account</p>
            </div>

            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @php
                    $throttleUntil = session('throttle_until');
                    $isThrottled = $throttleUntil && now() < $throttleUntil;
                    $loginAttempts = session('login_attempts', 0);
                    $attemptsRemaining = max(0, 2 - $loginAttempts);
                @endphp

                <!-- Countdown Timer (Hidden by default) -->
                <div id="countdownSection" class="alert alert-danger" style="display: {{ $isThrottled ? 'block' : 'none' }}; background: #fee2e2; border: 2px solid #fca5a5; text-align: center;">
                    <div style="font-size: 18px; font-weight: 700; color: #dc2626; margin-bottom: 10px;">⏱️ Too Many Attempts</div>
                    <div style="font-size: 36px; font-weight: 900; color: #dc2626; font-family: 'Courier New', monospace; letter-spacing: 3px; margin-bottom: 10px;">
                        <span id="countdownTimer">10</span>s
                    </div>
                    <div style="font-size: 14px; color: #991b1b;">Please wait before trying again</div>
                </div>

                <form action="{{ route('login') }}" method="POST" id="loginForm" style="display: {{ $isThrottled ? 'none' : 'block' }};">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            class="form-input @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="Enter your email address"
                            value="{{ old('email') }}"
                            required
                            autofocus>
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
                            placeholder="Enter your password"
                            required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="remember-checkbox">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="login-button" id="loginBtn">Sign In</button>
                </form>
            </div>

            <div class="login-footer">
                <p class="login-footer-text">
                    Don't have an account? <a href="{{ route('register') }}" class="login-footer-link">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownSection = document.getElementById('countdownSection');
            const countdownTimer = document.getElementById('countdownTimer');
            const loginForm = document.getElementById('loginForm');

            @if ($isThrottled)
                // Start countdown from throttle time (using milliseconds)
                const throttleUntilTime = {{ $throttleUntil->getTimestamp() * 1000 }};
                startCountdown(throttleUntilTime);
            @endif

            function startCountdown(throttleUntilTime) {
                let interval;
                
                const updateCountdown = () => {
                    const now = new Date().getTime();
                    const timeLeft = Math.ceil((throttleUntilTime - now) / 1000);
                    
                    if (timeLeft > 0) {
                        countdownTimer.textContent = timeLeft;
                    } else {
                        // Countdown finished
                        if (interval) clearInterval(interval);
                        countdownSection.style.display = 'none';
                        loginForm.style.display = 'block';
                        
                        // Reload to clear session
                        window.location.reload();
                    }
                };

                updateCountdown();
                interval = setInterval(updateCountdown, 1000);
            }
        });
    </script>
</body>
</html>
