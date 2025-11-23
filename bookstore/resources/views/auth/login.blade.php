@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
.login-container {
    min-height: calc(100vh - 300px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
}

.login-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    width: 100%;
    overflow: hidden;
}

.login-header {
    background: #f97316;
    padding: 2.5rem 2rem;
    text-align: center;
    color: white;
}

.login-header h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.login-header p {
    opacity: 0.95;
    font-size: 1rem;
}

.login-body {
    padding: 2.5rem 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #374151;
    font-size: 0.875rem;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s;
}

.form-input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
}

.form-input.error {
    border-color: #ef4444;
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-input {
    width: 1.125rem;
    height: 1.125rem;
    border: 2px solid #d1d5db;
    border-radius: 0.25rem;
    cursor: pointer;
}

.checkbox-label {
    font-size: 0.875rem;
    color: #6b7280;
    cursor: pointer;
}

.forgot-link {
    color: #f97316;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.3s;
}

.forgot-link:hover {
    color: #ea580c;
    text-decoration: underline;
}

.login-footer {
    background: #f9fafb;
    padding: 1.5rem 2rem;
    text-align: center;
    border-top: 1px solid #e5e7eb;
}

.register-link {
    color: #6b7280;
    font-size: 0.875rem;
}

.register-link a {
    color: #f97316;
    font-weight: 600;
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}

@media (max-width: 640px) {
    .login-header {
        padding: 2rem 1.5rem;
    }
    
    .login-header h1 {
        font-size: 1.5rem;
    }
    
    .login-body {
        padding: 2rem 1.5rem;
    }
}
</style>

<div class="login-container">
    <div class="login-card">
        
        <!-- Header -->
        <div class="login-header">
            <h1>📚 Welcome Back</h1>
            <p>Sign in to continue your reading journey</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div style="background: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: 1rem 1.5rem; margin: 1.5rem 2rem 0;">
            {{ session('status') }}
        </div>
        @endif

        <!-- Login Form -->
        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="you@example.com"
                    >
                    @error('email')
                    <p class="error-message">
                        <svg style="width: 1rem; height: 1rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="Enter your password"
                    >
                    @error('password')
                    <p class="error-message">
                        <svg style="width: 1rem; height: 1rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="checkbox-group">
                        <input 
                            type="checkbox" 
                            id="remember_me" 
                            name="remember"
                            class="checkbox-input"
                        >
                        <label for="remember_me" class="checkbox-label">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Forgot password?
                    </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Sign In
                </button>
            </form>
        </div>

        <!-- Footer -->
        @if (Route::has('register'))
        <div class="login-footer">
            <p class="register-link">
                Don't have an account? 
                <a href="{{ route('register') }}">Create one now</a>
            </p>
        </div>
        @endif

    </div>
</div>

@endsection