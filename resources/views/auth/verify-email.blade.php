@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-envelope"></i>
    </div>
    <h1 class="auth-title">Verify Your Email</h1>
    <p class="auth-subtitle">Please verify your email address to continue</p>
</div>

<div class="auth-body">
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            A new verification link has been sent to your email address.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="text-center mb-4">
        <i class="fas fa-envelope-open-text fa-4x text-primary mb-3"></i>
        <p class="mb-0">
            Before proceeding, please check your email for a verification link.
            If you didn't receive the email, we'll send you another.
        </p>
    </div>
    
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
            <i class="fas fa-paper-plane me-2"></i>
            Resend Verification Email
        </button>
    </form>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100 py-3">
            <i class="fas fa-sign-out-alt me-2"></i>
            Logout
        </button>
    </form>
</div>

<div class="auth-footer">
    <p class="mb-0 text-muted">
        &copy; {{ date('Y') }} {{ config('app.name') }} - All rights reserved
    </p>
</div>
@endsection

