@extends('layouts.app')

@section('content')
    <div class="form-wrap login-wrap">
        <div class="form-card login-card">
            <div class="login-mark" aria-hidden="true">+</div>
            <div class="eyebrow">Start fresh</div>
            <h1>Make your own space.</h1>
            <p>Create an account and keep your tasks in one calm, private place.</p>

            <form class="form-grid" action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="name">Your name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="e.g. Alex Morgan" autocomplete="name" maxlength="255" required autofocus>
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="At least 8 characters" autocomplete="new-password" minlength="8" required>
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter it again" autocomplete="new-password" minlength="8" required>
                </div>
                <button class="button login-button" type="submit">Create account</button>
            </form>

            <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
@endsection
