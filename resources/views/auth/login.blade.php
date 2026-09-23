@extends('layouts.app')

@section('content')
    <div class="form-wrap login-wrap">
        <div class="form-card login-card">
            <div class="login-mark" aria-hidden="true">✓</div>
            <div class="eyebrow">Welcome back</div>
            <h1>Let's get a few things done.</h1>
            <p>Sign in to pick up where you left off and see what is waiting on your list.</p>

            <form class="form-grid" action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>
                <label class="remember-field" for="remember">
                    <input id="remember" name="remember" type="checkbox" value="1">
                    <span>Keep me signed in</span>
                </label>
                <button class="button login-button" type="submit">Sign in</button>
            </form>

            <p class="demo-note">Demo account: <strong>demo@example.com</strong> / <strong>password</strong></p>
            <p class="auth-switch">New here? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </div>
@endsection
