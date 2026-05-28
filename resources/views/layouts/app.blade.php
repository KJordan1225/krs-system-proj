<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Organization Secretary' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .org-layout {
            min-height: 100vh;
            display: flex;
            background: #f4f6f9;
        }

        .org-sidebar {
            width: 260px;
            min-height: 100vh;
            background: #4b0082;
            color: #ffffff;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .org-sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            padding: 0.75rem 0.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 1rem;
        }

        .org-sidebar a {
            color: #d1d5db;
            text-decoration: none;
            padding: 0.7rem 0.85rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .org-sidebar a:hover,
        .org-sidebar a.active {
            background: #3a0066;
            color: #ffffff;
        }

        .org-main {
            flex: 1;
            min-width: 0;
        }

        .org-topbar {
            min-height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .org-content {
            padding: 1.5rem;
        }

        .btn-org-primary {
            background: #4b0082;
            border-color: #4b0082;
            color: #ffffff;
        }

        .btn-org-primary:hover {
            background: #3a0066;
            border-color: #3a0066;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .org-layout {
                flex-direction: column;
            }

            .org-sidebar {
                width: 100%;
                min-height: auto;
            }

            .org-topbar {
                height: auto;
                gap: 1rem;
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .org-content {
                padding: 1rem;
            }
        }
    </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="org-layout">
        <aside class="org-sidebar">
            <div class="org-sidebar-brand">
                Organization Secretary
            </div>

            <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('members.index') }}" class="{{ request()->is('members*') ? 'active' : '' }}">
                Members
            </a> 
            
            <a href="{{ route('events.index') }}" class="{{ request()->is('events*') ? 'active' : '' }}">
                Events
            </a>

            <a href="{{ route('finances.index') }}" class="{{ request()->is('finances*') ? 'active' : '' }}">
                Finances
            </a>

            <a href="{{ route('dues.index') }}" class="{{ request()->is('dues*') ? 'active' : '' }}">
                Dues Management
            </a>

        </aside>

        <main class="org-main">
            <header class="org-topbar">
                <div>
                    <strong>{{ $title ?? 'Dashboard' }}</strong>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span>{{ Auth::user()->name ?? 'Guest' }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="btn btn-sm btn-org-primary" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="org-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>

