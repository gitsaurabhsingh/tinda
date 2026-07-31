<x-guest-layout>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow border-0" style="max-width: 450px; width: 100%; border-radius: 16px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2">Reset Password</h3>
                    <p class="text-muted small">Choose a new password to secure your account.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium text-secondary small text-uppercase">Email Address</label>
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" style="border-radius: 10px;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium text-secondary small text-uppercase">New Password</label>
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="border-radius: 10px;">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium text-secondary small text-uppercase">Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" style="border-radius: 10px;">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold" style="border-radius: 10px; padding: 12px;">
                            Reset Password
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                            <i class="bi bi-arrow-left me-1"></i> Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
