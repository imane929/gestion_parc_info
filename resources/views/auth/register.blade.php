@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-user-plus"></i>
    </div>
    <h1 class="auth-title">Create Account</h1>
    <p class="auth-subtitle">Sign up to get started</p>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <!-- First Name -->
        <div class="mb-3">
            <label for="prenom" class="form-label">First Name</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" 
                       class="form-control @error('prenom') is-invalid @enderror" 
                       id="prenom" 
                       name="prenom" 
                       value="{{ old('prenom') }}" 
                       required>
            </div>
            @error('prenom')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Last Name -->
        <div class="mb-3">
            <label for="nom" class="form-label">Last Name</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" 
                       class="form-control @error('nom') is-invalid @enderror" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom') }}" 
                       required>
            </div>
            @error('nom')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Email -->
        <div class="mb-3">
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
                       required>
            </div>
            @error('email')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Phone -->
        <div class="mb-3">
            <label for="telephone" class="form-label">Phone (optional)</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-phone"></i>
                </span>
                <input type="text" 
                       class="form-control @error('telephone') is-invalid @enderror" 
                       id="telephone" 
                       name="telephone" 
                       value="{{ old('telephone') }}">
            </div>
            @error('telephone')
                <div class="text-danger mt-1">
                    <small>{{ $message }}</small>
                </div>
            @enderror
        </div>
        
        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required>
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
                       required>
            </div>
        </div>
        
        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
            <i class="fas fa-user-plus me-2"></i>
            Register
        </button>
        
        <a href="{{ route('login') }}" class="d-block text-center text-decoration-none">
            Already have an account? Sign in
        </a>
    </form>
</div>

<div class="auth-footer">
    <p class="mb-0 text-muted">
        &copy; {{ date('Y') }} {{ config('app.name') }} - All rights reserved
    </p>
</div>
@endsection

