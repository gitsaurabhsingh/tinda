@extends('admin.layout')
@section('title', 'Admin Profile')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold m-0 text-dark">My Profile</h2>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold m-0"><i class="fa-solid fa-user-circle text-primary me-2"></i> Update Profile Information</h5>
                    <p class="text-muted small mt-1">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="bio" class="form-label fw-bold">Bio</label>
                            <textarea class="form-control bg-light border-0 @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">A brief description about yourself.</div>
                        </div>

                        <hr class="my-4 border-light">

                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-lock text-warning me-2"></i> Change Password (Optional)</h6>
                        <p class="text-muted small mb-3">Leave blank if you do not want to change your password.</p>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">New Password</label>
                                <input type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" class="form-control form-control-lg bg-light border-0" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top border-light">
                            <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius: 10px;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
