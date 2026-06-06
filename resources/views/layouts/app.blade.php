<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS Application</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logopossapps.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logopossapps.png') }}">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @vite(['resources/js/app.js'])

    <!-- Custom Admin Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger-gradient: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
            --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
        }

        body {
            font-family: 'Poppins', 'Source Sans Pro', sans-serif;
            background: #f4f6f9;
        }

        /* Navbar Styling */
        .main-header {
            background: var(--primary-gradient) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .main-header .nav-link { color: rgba(255,255,255,0.9) !important; }
        .main-header .nav-link:hover { color: #fff !important; background: rgba(255,255,255,0.1); border-radius: 8px; }
        .navbar-badge { animation: pulse 2s infinite; }

        /* Sidebar Styling */
        .main-sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%) !important;
            box-shadow: 5px 0 25px rgba(0,0,0,0.1);
        }
        .main-sidebar .nav-link { color: rgba(255,255,255,0.7) !important; transition: all 0.3s ease; margin: 5px 10px; border-radius: 10px; }
        .main-sidebar .nav-link:hover { color: #fff !important; background: rgba(255,255,255,0.1); transform: translateX(5px); }
        .main-sidebar .nav-link.active { background: var(--primary-gradient) !important; color: #fff !important; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .main-sidebar .brand-link { border-bottom: 1px solid rgba(255,255,255,0.1); }
        .main-sidebar .brand-text { font-weight: 700; color: #fff !important; }

        /* Card Styling */
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; overflow: hidden; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .card-header { background: transparent; border-bottom: 1px solid rgba(0,0,0,0.05); font-weight: 600; }
        .card-body { padding: 1.5rem; }

        /* Modal Styling - Prevent hover effects from parents */
        .modal { transform: none !important; }
        .modal-content { transform: none !important; box-shadow: 0 25px 50px rgba(0,0,0,0.25) !important; }
        .modal-dialog { transform: none !important; }
        .modal.show .modal-dialog { transform: none !important; }
        .modal-backdrop { z-index: 1040 !important; }
        .modal { z-index: 1050 !important; }

        /* Small Box Animation */
        .small-box { border-radius: 15px; overflow: hidden; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: none; }
        .small-box:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .small-box > .inner { padding: 15px; }
        .small-box h3 { font-size: 2.2rem; font-weight: 700; }
        .small-box .icon { font-size: 70px; top: 10px; transition: all 0.3s ease; }
        .small-box:hover .icon { transform: scale(1.1) rotate(5deg); }
        .small-box-footer { background: rgba(0,0,0,0.1); color: rgba(255,255,255,0.8); }

        /* Gradient Backgrounds */
        .bg-gradient-primary { background: var(--primary-gradient) !important; }
        .bg-gradient-success { background: var(--success-gradient) !important; }
        .bg-gradient-info { background: var(--info-gradient) !important; }
        .bg-gradient-warning { background: var(--warning-gradient) !important; }
        .bg-gradient-danger { background: var(--danger-gradient) !important; }
        .bg-gradient-dark { background: var(--dark-gradient) !important; }

        /* Info Box Custom */
        .info-box-custom { background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; }
        .info-box-custom:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }

        /* Button Styling */
        .btn { border-radius: 10px; font-weight: 500; padding: 10px 20px; transition: all 0.3s ease; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        
        /* Disable hover effect for buttons inside modal */
        .modal .btn:hover { transform: none; box-shadow: none; }
        
        .btn-primary { background: var(--primary-gradient); border: none; }
        .btn-success { background: var(--success-gradient); border: none; }
        .btn-danger { background: var(--danger-gradient); border: none; }

        /* Table Styling */
        .table { border-radius: 10px; overflow: hidden; }
        .table thead th { background: var(--primary-gradient); color: #fff; border: none; font-weight: 600; }
        .table tbody tr { transition: all 0.3s ease; }
        .table tbody tr:hover { background: rgba(102, 126, 234, 0.1); }

        /* Badge Styling */
        .badge { padding: 5px 12px; border-radius: 20px; font-weight: 500; }

        /* Dropdown Styling */
        .dropdown-menu { border: none; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); padding: 10px; }
        .dropdown-item { border-radius: 8px; transition: all 0.2s ease; }
        .dropdown-item:hover { background: rgba(102, 126, 234, 0.1); transform: translateX(5px); }

        /* Content Header */
        .content-header h1 { font-weight: 700; color: #1a1a2e; }

        /* Breadcrumb */
        .breadcrumb { background: transparent; }
        .breadcrumb-item a { color: #667eea; }

        /* Footer */
        .main-footer { background: #fff; border-top: 1px solid rgba(0,0,0,0.05); }
        .main-footer.fixed-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
            padding: 12px 20px;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        body.sidebar-collapse .main-footer.fixed-bottom {
            margin-left: 4.6rem !important;
        }
        @media (max-width: 991px) {
            .main-footer.fixed-bottom {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-slideInLeft { animation: slideInLeft 0.5s ease-out forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: var(--primary-gradient); border-radius: 10px; }

        /* Welcome Card Special */
        .welcome-card { position: relative; overflow: hidden; }
        .welcome-card::before { content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; }
        .welcome-card::after { content: ''; position: absolute; bottom: -30%; left: -5%; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%; }

        /* Responsive */
        @media (max-width: 768px) {
            .small-box h3 { font-size: 1.8rem; }
            .small-box .icon { font-size: 50px; }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    @include('sweetalert::alert')

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link"><i class="fas fa-home mr-1"></i> Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">{{ $stokMenipis ?? 0 }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"><i class="fas fa-bell mr-2"></i>{{ $stokMenipis ?? 0 }} Notifikasi</span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('master-data.product.index') }}" class="dropdown-item">
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                            <span>{{ $stokMenipis ?? 0 }} Stok menipis</span>
                            <span class="float-right text-muted text-sm"><i class="fas fa-arrow-right"></i></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer text-center">Lihat Semua Notifikasi</a>
                    </div>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=667eea&color=fff&size=30"
                             class="img-circle elevation-2 mr-2" alt="Avatar" style="width: 30px; height: 30px;">
                        <span class="d-none d-sm-inline-block">
                            {{ ucwords(auth()->user()->name) }}
                            <span class="badge {{ auth()->user()->role == 'admin' ? 'badge-danger' : 'badge-info' }} ml-1">
                                {{ strtoupper(auth()->user()->role) }}
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center py-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=667eea&color=fff&size=80"
                                 class="img-circle elevation-3 mb-2" alt="Avatar" style="width: 70px; height: 70px;">
                            <p class="mb-0 font-weight-bold">{{ ucwords(auth()->user()->name) }}</p>
                            <small class="text-muted"><i class="fas fa-envelope mr-1"></i>{{ auth()->user()->email }}</small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#formKonfigurasiAkun">
                            <i class="fas fa-user-cog mr-2 text-primary"></i> Konfigurasi Akun
                        </button>
                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#formGantiPassword">
                            <i class="fas fa-key mr-2 text-warning"></i> Ganti Password
                        </button>
                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalPusatBantuan">
                            <i class="fas fa-question-circle mr-2 text-info"></i> Pusat Bantuan
                        </button>
                        <a href="{{ route('store.home') }}" class="dropdown-item" target="_blank">
                            <i class="fas fa-store mr-2 text-success"></i> V2
                        </a>

                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header"><i class="fas fa-globe mr-2"></i>Bahasa</h6>
                        <a href="#" class="dropdown-item"><span class="mr-2">🇮🇩</span> Indonesia</a>
                        <a href="#" class="dropdown-item"><span class="mr-2">🇬🇧</span> English</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <x-user.form-ganti-password />
        <x-user.form-konfigurasi-akun />
        <x-user.pusat-bantuan />
        <x-admin.aside />
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 animate-fadeInUp">@yield('content_tittle')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Home</a></li>
                                <li class="breadcrumb-item active">@yield('content_tittle')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Fixed Footer -->
        <footer class="main-footer text-sm fixed-bottom">
            <div class="float-right d-none d-sm-inline">
                <span class="text-primary font-weight-bold">POS Application</span>
            </div>
            <strong>Copyright &copy; 2026 <a href="#" class="text-primary">By. Dennis Adzua Firdaus</a>.</strong> All rights reserved.
        </footer>
        <!-- Spacer for fixed footer -->
        <div style="height: 50px;"></div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#table1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');
            $('#table2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
    @stack('script')
</body>
</html>
