@extends('layouts.app')

@section('title', 'Profile Settings - ' . ($settings["site_name"] ?? "Tindablog"))

@section('content')
<style>
    .dashboard-wrapper {
        min-height: 80vh;
        background-color: #f8fafc;
        padding-top: 2rem;
        padding-bottom: 4rem;
    }
    .settings-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }
    .settings-card-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 25px;
        padding-bottom: 15px;
    }
    .form-control {
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .form-control:focus {
        background-color: white;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(15, 42, 74, 0.1);
    }
    .btn-primary {
        border-radius: 12px !important;
        padding: 12px 30px !important;
    }
    .dash-sidebar {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }
    .dash-sidebar-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        padding: 30px 20px;
        text-align: center;
        color: white;
        position: relative;
    }
    .dash-sidebar-header::after {
        content: ''; position: absolute; bottom: -15px; left: 0; right: 0; height: 30px;
        background: white; border-radius: 50% 50% 0 0;
    }
    .profile-img-wrap {
        width: 90px; height: 90px;
        border-radius: 50%;
        padding: 4px;
        background: rgba(255,255,255,0.3);
        margin: 0 auto 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .profile-img-wrap img {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
    }
    .dash-nav-link {
        display: flex;
        align-items: center;
        padding: 14px 24px;
        color: #64748b;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    .dash-nav-link:hover {
        background: #f1f5f9;
        color: var(--primary);
    }
    .dash-nav-link.active {
        background: rgba(15, 42, 74, 0.05);
        color: var(--primary);
        border-left-color: var(--primary);
    }
    .dash-nav-link i {
        width: 24px;
        font-size: 1.1rem;
        margin-right: 12px;
        transition: transform 0.3s ease;
    }
    .dash-nav-link:hover i {
        transform: scale(1.1);
    }
</style>

<div class="dashboard-wrapper">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bolder text-dark mb-1">Profile Settings</h2>
                <p class="text-muted mb-0">Update your account details and password.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary shadow-sm rounded-pill px-4 py-2">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard
            </a>
        </div>

        <div class="row g-4">
            <!-- Left Sidebar -->
            <div class="col-lg-3">
                <div class="dash-sidebar">
                    <div class="dash-sidebar-header">
                        <div class="profile-img-wrap">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f2a4a&color=fff&size=128" alt="Profile">
                        </div>
                        <h5 class="fw-bold mb-0 text-white">{{ Auth::user()->name }}</h5>
                        <p class="small text-white-50 mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="py-3">
                        <a href="{{ route('dashboard') }}" class="dash-nav-link">
                            <i class="fa-solid fa-gauge"></i> Overview
                        </a>
                        <a href="{{ route('user.blogs.create') }}" class="dash-nav-link">
                            <i class="fa-solid fa-pen-nib"></i> Write Article
                        </a>
                        <a href="{{ route('profile.edit') }}" class="dash-nav-link active">
                            <i class="fa-solid fa-gear"></i> Settings
                        </a>
                        <hr class="mx-4 my-2 opacity-10">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dash-nav-link w-100 text-start bg-transparent border-0 text-danger" style="border-left: 3px solid transparent;">
                                <i class="fa-solid fa-right-from-bracket text-danger"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success rounded-4 border-0 shadow-sm d-flex align-items-center p-3 mb-4">
                        <i class="fa-solid fa-circle-check fs-4 text-success me-3"></i>
                        <div class="fw-medium">Your profile information has been saved successfully.</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success rounded-4 border-0 shadow-sm d-flex align-items-center p-3 mb-4">
                        <i class="fa-solid fa-circle-check fs-4 text-success me-3"></i>
                        <div class="fw-medium">Your password has been updated successfully.</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Update Profile Information -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h4 class="fw-bold mb-1">Profile Information</h4>
                        <p class="text-muted small mb-0">Update your account's profile information and email address.</p>
                    </div>
                    
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @if($errors->has('name'))
                                <div class="text-danger small mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @if($errors->has('email'))
                                <div class="text-danger small mt-2">{{ $errors->first('email') }}</div>
                            @endif
                            
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-3">
                                    <p class="text-muted small">
                                        Your email address is unverified.
                                        <button form="send-verification" class="btn btn-link p-0 text-primary fw-bold text-decoration-none ms-1">Click here to re-send the verification email.</button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-success small fw-bold">A new verification link has been sent to your email address.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-primary fw-bold">Save Changes</button>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h4 class="fw-bold mb-1">Update Password</h4>
                        <p class="text-muted small mb-0">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        
                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-bold">Current Password</label>
                            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                            @if($errors->updatePassword->has('current_password'))
                                <div class="text-danger small mt-2">{{ $errors->updatePassword->first('current_password') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">New Password</label>
                            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                            @if($errors->updatePassword->has('password'))
                                <div class="text-danger small mt-2">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                            @if($errors->updatePassword->has('password_confirmation'))
                                <div class="text-danger small mt-2">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-primary fw-bold">Save Password</button>
                    </form>
                </div>

                <!-- Delete Account -->
                <div class="settings-card">
                    <div class="settings-card-header border-danger border-opacity-25">
                        <h4 class="fw-bold text-danger mb-1">Delete Account</h4>
                        <p class="text-muted small mb-0">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    </div>
                    
                    <button type="button" class="btn btn-outline-danger fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                        Delete Account
                    </button>
                    
                    <!-- Delete Modal -->
                    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                @csrf
                                @method('delete')
                                
                                <div class="modal-header bg-danger text-white border-0 pb-3">
                                    <h5 class="modal-title fw-bold">Are you sure you want to delete your account?</h5>
                                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <p class="mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                                    
                                    <div class="mb-3">
                                        <label for="delete_password" class="form-label fw-bold">Password</label>
                                        <input id="delete_password" name="password" type="password" class="form-control" placeholder="Password" required>
                                        @if($errors->userDeletion->has('password'))
                                            <div class="text-danger small mt-2">{{ $errors->userDeletion->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Delete Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
    });
</script>
@endif
@endsection
