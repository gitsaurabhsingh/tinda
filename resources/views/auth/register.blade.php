<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ $settings['site_name'] ?? 'Tindablog' }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background: linear-gradient(135deg, #0f172a, #1e1b4b); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 3rem; width: 100%; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .auth-title { color: white; font-weight: 700; font-size: 2rem; margin-bottom: 0.5rem; text-align: center; }
        .auth-subtitle { color: #9ca3af; text-align: center; margin-bottom: 2.5rem; }
        .input-group-text { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-right: none; color: #a5b4fc; border-radius: 12px 0 0 12px; }
        .form-control { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: white; border-radius: 0 12px 12px 0; padding: 12px 15px; }
        .form-control:focus { background: rgba(255, 255, 255, 0.15); border-color: #6366f1; color: white; box-shadow: none; }
        .form-control::placeholder { color: #9ca3af; }
        .btn-primary { background: linear-gradient(135deg, #4f46e5, #3b82f6); border: none; border-radius: 50px; padding: 12px; font-weight: 600; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(59, 130, 246, 0.4); }
        .auth-link { color: #818cf8; text-decoration: none; font-weight: 500; transition: color 0.3s ease; }
        .auth-link:hover { color: #a5b4fc; text-decoration: underline; }
        .back-home { position: absolute; top: 30px; left: 30px; color: rgba(255,255,255,0.6); text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .back-home:hover { color: white; }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-home"><i class="fa-solid fa-arrow-left me-2"></i> Back to Home</a>
    
    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="d-inline-flex justify-content-center align-items-center bg-primary text-white rounded-circle mb-3 shadow-lg" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #4f46e5, #8b5cf6) !important;">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join us and start publishing your blogs today!</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
            </div>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
            </div>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
            </div>
            
            <div class="mb-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
            </div>

            <button class="btn btn-primary w-100 mb-4" type="submit">Register <i class="fa-solid fa-arrow-right ms-2"></i></button>
            
            <div class="text-center text-muted">
                Already have an account? <a class="auth-link" href="{{ route('login') }}">Sign In</a>
            </div>
        </form>
    </div>
</body>
</html>