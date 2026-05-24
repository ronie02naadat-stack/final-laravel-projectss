<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $maintenance->title }} - System Maintenance</title>
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

        .container {
            max-width: 700px;
            width: 100%;
        }

        .maintenance-wrapper {
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

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 60px 40px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .icon-container {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: float 3s ease-in-out infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .icon-container svg {
            width: 50px;
            height: 50px;
            animation: spin 12s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .title {
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }

        .message {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            position: relative;
            z-index: 1;
            line-height: 1.5;
        }

        .content-section {
            padding: 50px 40px;
        }

        .status-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 28px;
            border-left: 5px solid #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .status-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .status-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #667eea;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #667eea;
            color: #ffffff;
        }

        .status-badge.ongoing {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #fff;
            border-radius: 50%;
            margin-right: 8px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }
        }

        .time-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .time-item {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .time-item:hover {
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-4px);
        }

        .time-label {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .time-value {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
        }

        .description-section {
            background: #f9fafb;
            padding: 24px;
            border-radius: 12px;
            border-left: 4px solid #667eea;
            margin-bottom: 28px;
        }

        .description-label {
            font-size: 13px;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .description-text {
            font-size: 15px;
            color: #4b5563;
            line-height: 1.7;
        }

        .footer-section {
            background: #f9fafb;
            padding: 32px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }

        .footer-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-section {
                padding: 50px 30px 30px;
            }

            .title {
                font-size: 26px;
            }

            .message {
                font-size: 16px;
            }

            .content-section {
                padding: 40px 30px;
            }

            .time-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .header-section {
                padding: 40px 24px 24px;
            }

            .icon-container {
                width: 80px;
                height: 80px;
            }

            .icon-container svg {
                width: 40px;
                height: 40px;
            }

            .title {
                font-size: 22px;
            }

            .message {
                font-size: 14px;
            }

            .content-section {
                padding: 30px 24px;
            }

            .status-card {
                padding: 18px;
            }

            .time-value {
                font-size: 16px;
            }

            .footer-section {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="maintenance-wrapper">
            <div class="header-section">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="title">{{ $maintenance->title }}</h1>
                <p class="message">{{ $maintenance->message }}</p>
            </div>

            <div class="content-section">
                <div class="status-card ongoing">
                    <div class="status-header">
                        <span class="status-label">System Status</span>
                        <div class="status-badge ongoing">
                            @if($maintenance->status === 'ongoing')
                                <span class="pulse-dot"></span>
                            @endif
                            {{ ucfirst($maintenance->status) }}
                        </div>
                    </div>

                    @if($maintenance->scheduled_start || $maintenance->scheduled_end)
                    <div class="time-grid">
                        @if($maintenance->scheduled_start)
                        <div class="time-item">
                            <div class="time-label">Scheduled Start</div>
                            <div class="time-value">{{ $maintenance->scheduled_start->format('M j, Y') }}</div>
                            <div style="font-size: 13px; color: #9ca3af; margin-top: 4px;">{{ $maintenance->scheduled_start->format('g:i A') }}</div>
                        </div>
                        @endif
                        @if($maintenance->scheduled_end)
                        <div class="time-item">
                            <div class="time-label">Expected Completion</div>
                            <div class="time-value">{{ $maintenance->scheduled_end->format('M j, Y') }}</div>
                            <div style="font-size: 13px; color: #9ca3af; margin-top: 4px;">{{ $maintenance->scheduled_end->format('g:i A') }}</div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                @if($maintenance->description)
                <div class="description-section">
                    <div class="description-label">Details</div>
                    <div class="description-text">{{ $maintenance->description }}</div>
                </div>
                @endif
            </div>

            <div class="footer-section">
                <p class="footer-text">Need urgent assistance? <a href="mailto:support@example.com" class="footer-link">Contact support</a></p>
            </div>
        </div>
    </div>
</body>
</html>
