<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            color: white;
        }
        .error-code {
            font-size: 150px;
            font-weight: 700;
            line-height: 1;
            text-shadow: 4px 4px 0 rgba(0,0,0,0.1);
        }
        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        .btn-back {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div class="error-code">403</div>
        <h1 class="mt-3">Akses Ditolak</h1>
        <p class="lead mt-2">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <p class="text-white-50">Fitur ini hanya tersedia untuk pengguna dengan role tertentu.</p>
        <a href="{{ url()->previous() ?: route('dashboard.index') }}" class="btn btn-back mt-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</body>
</html>
