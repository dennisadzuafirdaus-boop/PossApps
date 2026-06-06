<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS Application - Login</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logopossapps.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logopossapps.png') }}">
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.3);
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
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .bubble {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3), rgba(118, 75, 162, 0.3));
            animation: float 15s infinite;
            opacity: 0.6;
        }

        .bg-animation .bubble:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .bg-animation .bubble:nth-child(2) { width: 100px; height: 100px; left: 20%; animation-delay: 2s; }
        .bg-animation .bubble:nth-child(3) { width: 60px; height: 60px; left: 35%; animation-delay: 4s; }
        .bg-animation .bubble:nth-child(4) { width: 120px; height: 120px; left: 50%; animation-delay: 6s; }
        .bg-animation .bubble:nth-child(5) { width: 80px; height: 80px; left: 65%; animation-delay: 1s; }
        .bg-animation .bubble:nth-child(6) { width: 150px; height: 150px; left: 80%; animation-delay: 3s; }
        .bg-animation .bubble:nth-child(7) { width: 90px; height: 90px; left: 90%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 0.6; }
            90% { opacity: 0.6; }
            100% { transform: translateY(-100vh) scale(1); opacity: 0; }
        }

        /* Floating Shapes */
        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: floatShape 20s infinite ease-in-out;
        }

        .shape:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { top: 60%; left: 80%; animation-delay: 3s; }
        .shape:nth-child(3) { top: 40%; left: 60%; animation-delay: 6s; }
        .shape:nth-child(4) { top: 80%; left: 30%; animation-delay: 9s; }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(90deg); }
            50% { transform: translate(-20px, -50px) rotate(180deg); }
            75% { transform: translate(20px, 30px) rotate(270deg); }
        }

        /* Main Container */
        .login-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Glass Card */
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Left Side - Branding */
        .login-brand {
            flex: 1;
            background: var(--primary-gradient);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.3; }
        }

        .brand-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
        }

        .brand-logo {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-out;
        }

        .brand-logo i {
            animation: rotate 20s linear infinite;
            display: inline-block;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            animation: fadeIn 1s ease-out 0.2s both;
        }

        .brand-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            animation: fadeIn 1s ease-out 0.4s both;
        }

        .brand-features {
            margin-top: 40px;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            text-align: left;
        }

        .feature-item i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .feature-item:hover i {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Right Side - Form */
        .login-form-side {
            flex: 1;
            padding: 60px 50px;
            background: rgba(255, 255, 255, 0.95);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
            animation: fadeIn 1s ease-out both;
        }

        .form-group:nth-child(1) { animation-delay: 0.4s; }
        .form-group:nth-child(2) { animation-delay: 0.5s; }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control:focus + i,
        .input-group-custom:focus-within i {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            animation: fadeIn 1s ease-out 0.6s both;
        }

        .remember-me {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .remember-me input {
            margin-right: 8px;
            accent-color: #667eea;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #764ba2;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease-out 0.7s both;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login i {
            margin-right: 8px;
        }

        /* Error Alert */
        .alert-danger {
            background: rgba(255, 77, 77, 0.1);
            border: 1px solid rgba(255, 77, 77, 0.3);
            border-radius: 12px;
            color: #d63031;
            padding: 15px 20px;
            margin-bottom: 25px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            animation: fadeIn 1s ease-out 0.8s both;
        }

        .login-footer p {
            color: #666;
            font-size: 0.9rem;
        }

        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            color: #764ba2;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 400px;
            }

            .login-brand {
                padding: 40px 30px;
            }

            .login-form-side {
                padding: 40px 30px;
            }

            .brand-logo {
                font-size: 2rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .brand-features {
                display: none;
            }
        }

        /* Loading Animation */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-login.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape"><i class="fas fa-shopping-cart fa-4x text-white"></i></div>
        <div class="shape"><i class="fas fa-box fa-4x text-white"></i></div>
        <div class="shape"><i class="fas fa-chart-line fa-4x text-white"></i></div>
        <div class="shape"><i class="fas fa-cog fa-4x text-white"></i></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Left Side - Branding -->
            <div class="login-brand">
                <div class="brand-content">
                    <div class="brand-logo">
                        <i class="fas fa-store"></i>
                    </div>
                    <h1 class="brand-title">POS Application</h1>
                    <p class="brand-subtitle">Point of Sale Management System</p>
                    
                    <div class="brand-features">
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Kelola produk dengan mudah</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Monitoring stok real-time</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Laporan penjualan lengkap</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check"></i>
                            <span>Multi-user & role management</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="login-form-side">
                <div class="form-header">
                    <h2>Selamat Datang!</h2>
                    <p>Silakan masuk ke akun Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-group-custom">
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="Masukkan email Anda"
                                   value="{{ old('email') }}"
                                   autofocus
                                   required>
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group-custom">
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Masukkan password Anda"
                                   id="password"
                                   required>
                            <i class="fas fa-lock"></i>
                            <button type="button" class="toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #667eea;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-login" id="btnLogin">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </button>
                </form>

                <div class="login-footer">
                    <p>&copy; 2026 POS Application. Developed by <a href="#">Dennis Adzua Firdaus</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Toggle Password Visibility
            $('.toggle-password').on('click', function() {
                const passwordInput = $('#password');
                const icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Form Submit Animation
            $('#loginForm').on('submit', function() {
                const btn = $('#btnLogin');
                btn.addClass('loading');
                btn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
            });

            // Input Focus Animation
            $('.form-control').on('focus', function() {
                $(this).parent().find('i').css('transform', 'translateY(-50%) scale(1.2)');
            });

            $('.form-control').on('blur', function() {
                $(this).parent().find('i').css('transform', 'translateY(-50%) scale(1)');
            });
        });
    </script>
</body>
</html>
