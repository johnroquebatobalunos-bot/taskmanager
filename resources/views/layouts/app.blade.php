<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Taskflow' }} | Personal Task Manager</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite('resources/css/app.css')
    @else
        <link rel="stylesheet" href="{{ asset('app.css') }}">
    @endif
</head>
<body>
    <div class="shell">
        <header class="topbar">
            <a class="brand" href="{{ route('tasks.index') }}">
                <span class="brand-mark" aria-hidden="true"></span>
                <span>Taskflow</span>
            </a>
            @auth
                <div class="account-bar">
                    <span class="topbar-note">Hi, {{ auth()->user()->name }}.</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="logout-button" type="submit">Log out</button>
                    </form>
                </div>
            @else
                <span class="topbar-note">Small steps count.</span>
            @endauth
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
