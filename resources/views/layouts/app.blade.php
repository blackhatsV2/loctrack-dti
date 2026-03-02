<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Employee Tracker') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-dark: #0f172a;
            --glass: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0, transparent 50%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            margin-left: 2rem;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        main {
            flex: 1;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1100px;
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        button, .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav>
        <div class="logo">LocTrack Pro</div>
        <div class="nav-links">
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.map') }}">Real-time Map</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 2rem;">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    @yield('scripts')
</body>
</html>
