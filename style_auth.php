<?php
$registerFile = __DIR__ . '/resources/views/auth/register.blade.php';
$loginFile = __DIR__ . '/resources/views/auth/login.blade.php';

$registerContent = <<<HTML
<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm border-0" style="width: 100%; max-width: 450px; border-radius: 15px;">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4">Create an Account</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                        <x-input-error :messages="\$errors->get('name')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="username">
                        <x-input-error :messages="\$errors->get('email')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        <x-input-error :messages="\$errors->get('password')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <x-input-error :messages="\$errors->get('password_confirmation')" class="mt-2 text-danger" />
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary fw-bold" style="border-radius: 30px; padding: 10px;" type="submit">Register</button>
                    </div>

                    <div class="mt-4 text-center">
                        <a class="text-decoration-none text-muted" href="{{ route('login') }}">
                            Already registered? <span class="text-primary fw-medium">Log in</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
HTML;

$loginContent = <<<HTML
<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm border-0" style="width: 100%; max-width: 450px; border-radius: 15px;">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4">Welcome Back</h3>
                <x-auth-session-status class="mb-4 text-success" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        <x-input-error :messages="\$errors->get('email')" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        <x-input-error :messages="\$errors->get('password')" class="mt-2 text-danger" />
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label text-muted">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none text-primary fw-medium text-sm" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary fw-bold" style="border-radius: 30px; padding: 10px;" type="submit">Log in</button>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a class="text-decoration-none text-muted" href="{{ route('register') }}">
                            Don't have an account? <span class="text-primary fw-medium">Sign up</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
HTML;

file_put_contents($registerFile, $registerContent);
file_put_contents($loginFile, $loginContent);

echo "Auth views styled with Bootstrap.";
