@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-shield-alt"></i>
    </div>
    <h1 class="auth-title">Confirmation Required</h1>
    <p class="auth-subtitle">Please confirm your password to continue</p>
</div>

<div class="auth-body">
    <div class="text-center mb-4">
        <i class="fas fa-lock fa-4x text-warning mb-3"></i>
        <p class="mb-0">
            This is a secure area. Please confirm your password before continuing.
        </p>
    </div>
    
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        
        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="••••••••"
                       required 
                       autofocus>
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
        
        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
            <i class="fas fa-check-circle me-2"></i>
            Confirm
        </button>
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

