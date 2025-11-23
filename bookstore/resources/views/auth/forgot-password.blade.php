@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<style>
.forgot-container {
    min-height: calc(100vh - 300px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
}

.forgot-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    max-width: 480px;
    width: 100%;
    overflow: hidden;
}

.forgot-header {
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    padding: 2.5rem 2rem;
    text-align: center;
    color: white;
}

.forgot-header h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.forgot-header p {
    opacity: 0.95;
    font-size: 0.875rem;
}

.forgot-body {
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
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.form-input.error {
    border-color: #ef4444;
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.forgot-footer {
    background: #f9fafb;
    padding: 1.5rem 2rem;
    text-align: center;
    border-top: 1px solid #e5e7eb;
}

.back-link {
    color: #6b7280;
    font-size: 0.875rem;
}

.back-link a {
    color: #8b5cf6;
    font-weight: 600;
    text-decoration: none;
}

.back-link a:hover {
    text-decoration: underline;
}
</style>

<div class="forgot-container">
    <div class="forgot-card">
        
        <!-- Header -->
        <div class="forgot-header">
            <h1>🔐 Reset Password</h1>
            <p>Enter your email and we'll send you a reset link</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div style="background: #d1fae5; border-left: 4px solid #10b981; color: #065f46; padding: 1rem 1.5rem; margin: 1.5rem 2rem 0;">
            {{ session('status') }}
        </div>
        @endif

        <!-- Form -->
        <div class="forgot-body">
            <form method="POST" action="{{ route('password.email') }}">
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
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="you@example.com"
                    >
                    @error('email')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem;">
                    Email Password Reset Link
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="forgot-footer">
            <p class="back-link">
                <a href="{{ route('login') }}">← Back to login</a>
            </p>
        </div>

    </div>
</div>

@endsection