<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ $settings['site_name'] ?? 'Tindablog' }}</title>
    <!-- Favicon -->
    @if(isset($settings['site_logo']) && !empty($settings['site_logo']))
        <link rel="icon" href="{{ $settings['site_logo'] }}">
    @endif
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #0f2a4a;
            --secondary: #1e3a5f;
            --accent: #0d6efd;
        }
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .login-left {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .login-left i {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.8;
        }
        .login-right {
            padding: 50px;
            background: white;
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .btn-login {
            background-color: var(--primary);
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card login-card row flex-row">
                    <!-- Left Side -->
                    <div class="col-md-5 login-left d-none d-md-flex">
                        <i class="fa-solid fa-shield-halved"></i>
                        <h3 class="fw-bold mb-3">Admin Portal</h3>
                        <p class="opacity-75">Secure access to the administration dashboard for {{ $settings['site_name'] ?? 'Tindablog' }}.</p>
                        <a href="{{ url('/') }}" class="btn btn-outline-light rounded-pill mt-4 px-4"><i class="fa-solid fa-arrow-left me-2"></i> Back to Site</a>
                    </div>
                    
                    <!-- Right Side -->
                    <div class="col-md-7 login-right">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-dark">Welcome Back</h4>
                            <p class="text-muted">Please sign in to your administrator account</p>
                        </div>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.post') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0 bg-light" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold mb-0">Password</label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0 bg-light" id="password" name="password" required placeholder="••••••••">
                                </div>
                            </div>
                            
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label text-muted" for="remember_me">Remember me</label>
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Secure Login
                            </button>
                            
                            <div class="text-center mt-4 d-md-none">
                                <a href="{{ url('/') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Back to Site</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
