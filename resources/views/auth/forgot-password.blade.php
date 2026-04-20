@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-key"></i>
    </div>
    <h1 class="auth-title">Forgot Password?</h1>
    <p class="auth-subtitle">Enter your email to reset your password</p>
</div>

<div class="auth-body">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
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
                       value="{{ old('email') }}" 
                       placeholder="your@email.com"
                       required 
                       autofocus>
            </div>
            @error('email')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
            <i class="fas fa-paper-plane me-2"></i>
            Send Reset Link
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
@endsection

