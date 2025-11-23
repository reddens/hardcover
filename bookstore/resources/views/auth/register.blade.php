@extends('layouts.app')

@section('title', 'Register')

@section('content')

<style>
.register-container {
    min-height: calc(100vh - 300px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
}

.register-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    max-width: 520px;
    width: 100%;
    overflow: hidden;
}

.register-header {
    background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
    padding: 2.5rem 2rem;
    text-align: center;
    color: white;
}

.register-header h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.register-header p {
    opacity: 0.95;
    font-size: 1rem;
}

.register-body {
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
    border-color: #ec4899;
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
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

.register-footer {
    background: #f9fafb;
    padding: 1.5rem 2rem;
    text-align: center;
    border-top: 1px solid #e5e7eb;
}

.login-link {
    color: #6b7280;
    font-size: 0.875rem;
}

.login-link a {
    color: #ec4899;
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}

@media (max-width: 640px) {
    .register-header {
        padding: 2rem 1.5rem;
    }
    
    .register-header h1 {
        font-size: 1.5rem;
    }
    
    .register-body {
        padding: 2rem 1.5rem;
    }
}
</style>

<div class="register-container">
    <div class="register-card">
        
        <!-- Header -->
        <div class="register-header">
            <h1>📚 Join Our Community</h1>
            <p>Create an account to start your reading adventure</p>
        </div>

        <!-- Registration Form -->
        <div class="register-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name"
                        class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                        placeholder="John Doe"
                    >
                    @error('name')
                    <p class="error-message">
                        <svg style="width: 1rem; height: 1rem;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
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
                        autocomplete="new-password"
                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="Create a secure password"
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

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        class="form-input"
                        placeholder="Re-enter your password"
                    >
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Create Account
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="register-footer">
            <p class="login-link">
                Already have an account? 
                <a href="{{ route('login') }}">Sign in here</a>
            </p>
        </div>

    </div>
</div>

@endsection