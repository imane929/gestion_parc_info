@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-lock"></i>
    </div>
    <h1 class="auth-title">New Password</h1>
    <p class="auth-subtitle">Create a new secure password</p>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $request->email) }}" 
                       required 
                       readonly>
            </div>
            @error('email')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="••••••••"
                       required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="••••••••"
                       required>
            </div>
        </div>
        
        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
            <i class="fas fa-save me-2"></i>
            Reset Password
        </button>
        
        <!-- Back to login -->
        <a href="{{ route('login') }}" class="d-block text-center text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i>
            Back to Login
        </a>
    </form>
</div>

<div class="auth-footer">
    <p class="mb-0 text-muted">
        &copy; {{ date('Y') }} {{ config('app.name') }} - All rights reserved
    </p>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
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
    });
</script>
@endpush
@endsection

