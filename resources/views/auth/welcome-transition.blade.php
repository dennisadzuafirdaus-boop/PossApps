<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - POS Application</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logopossapps.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logopossapps.png') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f093fb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Main Container */
        .welcome-container {
            text-align: center;
            position: relative;
            z-index: 10;
        }

        /* Animated Background Circles */
        .bg-circles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            animation: circleFloat 8s ease-in-out infinite;
        }

        .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            right: -100px;
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            right: -75px;
            animation-delay: 4s;
        }

        .circle:nth-child(4) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: -50px;
            animation-delay: 1s;
        }

        @keyframes circleFloat {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(180deg); }
        }

        /* Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            animation: particleFloat 10s infinite linear;
            opacity: 0;
        }

        @keyframes particleFloat {
            0% {
                opacity: 0;
                transform: translateY(100vh) scale(0);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(1);
            }
        }

        /* Logo Animation */
        .logo-wrapper {
            margin-bottom: 40px;
            animation: logoEntry 1s ease-out forwards;
        }

        .logo-circle {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: logoPulse 2s ease-in-out infinite;
            box-shadow: 0 0 60px rgba(102, 126, 234, 0.5);
        }

        .logo-circle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: logoRipple 1.5s ease-out infinite;
        }

        .logo-circle::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: logoRipple 1.5s ease-out infinite 0.5s;
        }

        @keyframes logoRipple {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .logo-circle i {
            font-size: 60px;
            color: white;
            animation: iconBounce 2s ease-in-out infinite;
        }

        @keyframes iconBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes logoEntry {
            from {
                opacity: 0;
                transform: scale(0.5) rotate(-180deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 0 60px rgba(102, 126, 234, 0.5); }
            50% { box-shadow: 0 0 100px rgba(102, 126, 234, 0.8); }
        }

        /* Welcome Text */
        .welcome-text {
            color: white;
            margin-bottom: 30px;
            animation: textFadeIn 1s ease-out 0.5s both;
        }

        .welcome-text h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-text .username {
            font-size: 2rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: usernameGlow 2s ease-in-out infinite;
        }

        @keyframes usernameGlow {
            0%, 100% { filter: drop-shadow(0 0 10px rgba(102, 126, 234, 0.5)); }
            50% { filter: drop-shadow(0 0 20px rgba(102, 126, 234, 0.8)); }
        }

        @keyframes textFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Role Badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 10px 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3), rgba(118, 75, 162, 0.3));
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: white;
            font-weight: 500;
            margin-bottom: 40px;
            animation: badgeEntry 1s ease-out 0.8s both;
            backdrop-filter: blur(10px);
        }

        .role-badge i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        @keyframes badgeEntry {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Loading Bar */
        .loading-container {
            width: 300px;
            margin: 0 auto;
            animation: loadingEntry 1s ease-out 1s both;
        }

        .loading-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .loading-bar {
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .loading-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--primary));
            background-size: 200% 100%;
            animation: loadingProgress 2s ease-in-out forwards, shimmer 1s linear infinite;
            border-radius: 10px;
        }

        @keyframes loadingProgress {
            from { width: 0%; }
            to { width: 100%; }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes loadingEntry {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Feature Icons */
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 50px;
            animation: featuresEntry 1s ease-out 1.2s both;
        }

        .feature-item {
            text-align: center;
            opacity: 0;
            animation: featureFadeIn 0.5s ease-out forwards;
        }

        .feature-item:nth-child(1) { animation-delay: 1.3s; }
        .feature-item:nth-child(2) { animation-delay: 1.4s; }
        .feature-item:nth-child(3) { animation-delay: 1.5s; }
        .feature-item:nth-child(4) { animation-delay: 1.6s; }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-item:hover .feature-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .feature-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
        }

        @keyframes featuresEntry {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes featureFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Redirect Text */
        .redirect-text {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
            animation: blinkText 1s ease-in-out infinite;
        }

        @keyframes blinkText {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Confetti */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            top: -10px;
            animation: confettiFall 3s linear forwards;
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Background Circles -->
    <div class="bg-circles">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <!-- Particles -->
    <div class="particles" id="particles"></div>

    <!-- Main Content -->
    <div class="welcome-container">
        <!-- Logo -->
        <div class="logo-wrapper">
            <div class="logo-circle">
                <i class="fas fa-store"></i>
            </div>
        </div>

        <!-- Welcome Text -->
        <div class="welcome-text">
            <h1>Selamat Datang,</h1>
            <div class="username">{{ ucwords(auth()->user()->name) }}</div>
        </div>

        <!-- Role Badge -->
        <div class="role-badge">
            <i class="fas {{ auth()->user()->role == 'admin' ? 'fa-user-shield' : 'fa-user' }}"></i>
            <span>{{ strtoupper(auth()->user()->role) }}</span>
        </div>

        <!-- Loading Bar -->
        <div class="loading-container">
            <div class="loading-text">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Memuat dashboard...
            </div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>

        <!-- Features -->
        <div class="features">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="feature-text">Produk</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="feature-text">Laporan</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="feature-text">Penjualan</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="feature-text">Pengguna</div>
            </div>
        </div>
    </div>

    <!-- Redirect Text -->
    <div class="redirect-text">
        <i class="fas fa-arrow-right mr-2"></i>
        Mengalihkan ke dashboard dalam beberapa detik...
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Generate Particles
            const particlesContainer = document.getElementById('particles');
            const colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe'];
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.animationDuration = (Math.random() * 5 + 5) + 's';
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
                particle.style.width = (Math.random() * 10 + 5) + 'px';
                particle.style.height = particle.style.width;
                particlesContainer.appendChild(particle);
            }

            // Generate Confetti
            function createConfetti() {
                const colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#00f2fe', '#38ef7d'];
                for (let i = 0; i < 50; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animationDelay = Math.random() * 0.5 + 's';
                    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 3000);
                }
            }

            // Trigger confetti on load
            setTimeout(createConfetti, 500);

            // Redirect after animation
            setTimeout(function() {
                window.location.href = '{{ route("dashboard.index") }}';
            }, 3500);
        });
    </script>
</body>
</html>
