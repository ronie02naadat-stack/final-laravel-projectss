@if($promotion = \App\Models\Promotion::getActive())
<div class="mega-promo">
    <div class="promo-glow"></div>
    
    <div class="promo-wrapper">
        <!-- Left: Large Discount Badge -->
        <div class="discount-section">
            <div class="discount-badge">
                <div class="discount-inner">
                    <span class="discount-text">{{ $promotion->discount_percentage }}%</span>
                    <span class="discount-sub">OFF</span>
                </div>
            </div>
            <div class="deal-stars">⭐ Limited Time ⭐</div>
        </div>

        <!-- Center: Main Content -->
        <div class="content-section">
            <h2 class="promo-headline">{{ $promotion->title }}</h2>
            <p class="promo-subtext">{{ $promotion->description ?? "Enjoy " . $promotion->discount_percentage . "% off on all items!" }}</p>
            
            <div class="urgency-text">
                🚨 <span class="highlight">Only on May 5, 2026!</span> Don't miss out! 🚨
            </div>
        </div>

        <!-- Right: Timer -->
        <div class="timer-section">
            <div class="timer-header">⏰ Time Remaining:</div>
            <div class="timer-display" id="countdown">
                <div class="timer-unit">
                    <div class="timer-val" id="days">00</div>
                    <div class="timer-unit-label">DAYS</div>
                </div>
                <div class="timer-divider"></div>
                <div class="timer-unit">
                    <div class="timer-val" id="hours">00</div>
                    <div class="timer-unit-label">HRS</div>
                </div>
                <div class="timer-divider"></div>
                <div class="timer-unit">
                    <div class="timer-val" id="minutes">00</div>
                    <div class="timer-unit-label">MINS</div>
                </div>
                <div class="timer-divider"></div>
                <div class="timer-unit">
                    <div class="timer-val" id="seconds">00</div>
                    <div class="timer-unit-label">SECS</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Button -->
    <a href="#" class="mega-cta-btn">
        🛍️ SHOP NOW & SAVE BIG! 🛍️
    </a>

    <!-- Animated decorative elements -->
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
</div>

<style>
    .mega-promo {
        position: relative;
        width: 100%;
        background: linear-gradient(135deg, #ff1744 0%, #f50057 50%, #c51162 100%);
        color: #ffffff;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(255, 23, 68, 0.3);
        animation: slideInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-bottom: 4px solid #ffeb3b;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .promo-glow {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: radial-gradient(ellipse at 50% 50%, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        pointer-events: none;
        z-index: 1;
    }

    .promo-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 40px;
        display: grid;
        grid-template-columns: 120px 1fr 1fr;
        gap: 40px;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    /* Discount Badge Section */
    .discount-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .discount-badge {
        width: 120px;
        height: 120px;
        background: radial-gradient(circle, #ffeb3b 0%, #fdd835 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        animation: spin 8s linear infinite;
        border: 3px solid #fff;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .discount-inner {
        text-align: center;
        animation: counterSpin 8s linear infinite;
    }

    @keyframes counterSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(-360deg); }
    }

    .discount-text {
        display: block;
        font-size: 48px;
        font-weight: 900;
        color: #d32f2f;
        line-height: 1;
    }

    .discount-sub {
        display: block;
        font-size: 18px;
        font-weight: 700;
        color: #d32f2f;
        letter-spacing: 1px;
    }

    .deal-stars {
        font-size: 14px;
        font-weight: 700;
        text-align: center;
        animation: twinkle 1.5s infinite;
    }

    @keyframes twinkle {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    /* Content Section */
    .content-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .promo-headline {
        margin: 0;
        font-size: 36px;
        font-weight: 900;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        letter-spacing: -1px;
    }

    .promo-subtext {
        margin: 12px 0 0 0;
        font-size: 18px;
        font-weight: 500;
        opacity: 0.95;
    }

    .urgency-text {
        margin-top: 16px;
        font-size: 16px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.15);
        padding: 12px 16px;
        border-radius: 8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        animation: pulse-glow 2s infinite;
    }

    @keyframes pulse-glow {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    .highlight {
        color: #ffeb3b;
        text-decoration: underline;
        font-size: 18px;
    }

    /* Timer Section */
    .timer-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        background: rgba(0, 0, 0, 0.2);
        padding: 20px;
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
    }

    .timer-header {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.9);
    }

    .timer-display {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .timer-unit {
        text-align: center;
        flex: 0 0 auto;
    }

    .timer-val {
        font-size: 28px;
        font-weight: 900;
        font-variant-numeric: tabular-nums;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .timer-unit-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 4px;
    }

    .timer-divider {
        width: 2px;
        height: 40px;
        background: rgba(255, 255, 255, 0.3);
    }

    /* CTA Button */
    .mega-cta-btn {
        display: block;
        width: calc(100% - 80px);
        max-width: 600px;
        margin: 20px auto;
        padding: 16px 32px;
        background: linear-gradient(135deg, #ffeb3b 0%, #fdd835 100%);
        color: #d32f2f;
        font-size: 18px;
        font-weight: 900;
        text-align: center;
        text-decoration: none;
        border-radius: 30px;
        border: 3px solid #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        letter-spacing: 1px;
        position: relative;
        z-index: 3;
    }

    .mega-cta-btn:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
    }

    .mega-cta-btn:active {
        transform: translateY(-2px) scale(0.98);
    }

    /* Confetti animations */
    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #ffeb3b;
        opacity: 0.7;
        border-radius: 50%;
        pointer-events: none;
        animation: confettiFall 3s ease-in infinite;
        z-index: 0;
    }

    .confetti:nth-child(1) {
        left: 10%;
        animation-delay: 0s;
    }

    .confetti:nth-child(2) {
        left: 25%;
        animation-delay: 0.5s;
    }

    .confetti:nth-child(3) {
        left: 50%;
        animation-delay: 1s;
    }

    .confetti:nth-child(4) {
        left: 75%;
        animation-delay: 0.3s;
    }

    .confetti:nth-child(5) {
        left: 90%;
        animation-delay: 0.7s;
    }

    @keyframes confettiFall {
        0% {
            transform: translateY(-10px);
            opacity: 0;
        }
        10% {
            opacity: 0.7;
        }
        90% {
            opacity: 0.7;
        }
        100% {
            transform: translateY(100px) rotate(360deg);
            opacity: 0;
        }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .promo-wrapper {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 20px 30px;
        }

        .discount-section {
            order: -1;
        }

        .timer-section {
            order: 2;
        }
    }

    @media (max-width: 768px) {
        .promo-headline {
            font-size: 28px;
        }

        .promo-subtext {
            font-size: 16px;
        }

        .discount-badge {
            width: 90px;
            height: 90px;
        }

        .discount-text {
            font-size: 36px;
        }

        .discount-sub {
            font-size: 14px;
        }

        .timer-val {
            font-size: 22px;
        }

        .mega-cta-btn {
            font-size: 16px;
            padding: 14px 24px;
        }
    }

    @media (max-width: 480px) {
        .promo-wrapper {
            padding: 16px 20px;
        }

        .promo-headline {
            font-size: 22px;
        }

        .promo-subtext {
            font-size: 14px;
        }

        .urgency-text {
            font-size: 13px;
            padding: 10px 12px;
        }

        .discount-badge {
            width: 80px;
            height: 80px;
        }

        .discount-text {
            font-size: 32px;
        }

        .timer-display {
            gap: 8px;
        }

        .timer-val {
            font-size: 18px;
        }

        .timer-unit-label {
            font-size: 8px;
        }

        .timer-divider {
            height: 30px;
        }

        .mega-cta-btn {
            font-size: 14px;
            padding: 12px 20px;
            width: calc(100% - 40px);
        }
    }
</style>

<script>
    function updateCountdown() {
        const endDate = new Date('{{ $promotion->end_date->toDateTimeString() }}').getTime();
        const now = new Date().getTime();
        const distance = endDate - now;

        if (distance <= 0) {
            document.getElementById('countdown').style.display = 'none';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endif
