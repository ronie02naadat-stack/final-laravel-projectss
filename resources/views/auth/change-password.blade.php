<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - RFN Project</title>
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

        .password-container {
            width: 100%;
            max-width: 420px;
        }

        .password-card {
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

        .password-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }

        .password-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .password-header p {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.5;
        }

        .password-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group:last-of-type {
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .password-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .password-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .password-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error-list {
            list-style: none;
            padding-left: 0;
        }

        .error-list li {
            padding: 5px 0;
        }

        .user-info {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .user-info strong {
            color: #333;
        }

        .user-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="password-card">
            <div class="password-header">
                <h1>Change Password</h1>
                <p>Welcome! Please change your password before accessing your dashboard.</p>
            </div>
            
            <div class="password-body">
                <div class="user-info">
                    <p><strong>User:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>

                @if ($errors->any())
                    <div class="error-message">
                        <strong>Please fix the following errors:</strong>
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.change.update') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            placeholder="Enter your new password"
                            value="{{ old('new_password') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm Password</label>
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            placeholder="Confirm your new password"
                            value="{{ old('new_password_confirmation') }}"
                            required
                        >
                    </div>

                    <button type="submit" class="password-btn">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
