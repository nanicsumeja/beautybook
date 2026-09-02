<!doctype html>
<html lang="bs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BeautyBook</title>

    <!-- Fontovi -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,700|manrope:400,500,600,700&display=swap"
        rel="stylesheet"
    >

    <!-- Stilovi i skripte -->
    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js'
    ])
    @stack('styles')
</head>

<body class="@yield('body-class')">

    <div id="app">

        <!-- Navbar se ne prikazuje na prijavi i registraciji -->
        @unless (Route::is('login') || Route::is('register'))

            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">

                    <a class="navbar-brand" href="{{ url('/') }}">
                        BeautyBook
                    </a>

                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Otvori navigaciju"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div
                        class="collapse navbar-collapse"
                        id="navbarSupportedContent"
                    >

                        <!-- Navigacija prema ulozi korisnika -->
                        <ul class="navbar-nav me-auto">

                            @auth

                                <!-- OWNER -->
                                @if (Auth::user()->role === 'owner')

                                    <li class="nav-item">
                                        <a
                                            href="{{ route('owner.dashboard') }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'owner.dashboard'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Dashboard
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'owner.services.index'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'owner.services.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Services
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'owner.reservations.index'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'owner.reservations.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Appointments
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route('owner.reports.index') }}"
                                            class="nav-link {{
                                                request()->routeIs('owner.reports.*')
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Reports
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'owner.employees.index'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'owner.employees.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Employees
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route('owner.clients.index') }}"
                                            class="nav-link {{ request()->routeIs('owner.clients.*') ? 'active' : '' }}"
                                        >
                                            Clients
                                        </a>
                                    </li>

                                @endif


                                <!-- CLIENT -->
                                @if (Auth::user()->role === 'client')

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'client.dashboard'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'client.dashboard'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Dashboard
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'client.services.index'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'client.services.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Services
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'client.reservations.index'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'client.reservations.*'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            My appointments
                                        </a>
                                    </li>

                                @endif

                                <!-- EMPLOYEE -->
                                @if (Auth::user()->role === 'employee')

                                    <li class="nav-item">
                                        <a
                                            href="{{ route(
                                                'employee.dashboard'
                                            ) }}"
                                            class="nav-link {{
                                                request()->routeIs(
                                                    'employee.dashboard'
                                                )
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Dashboard
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route('employee.schedule.index') }}"
                                            class="nav-link {{ request()->routeIs('employee.schedule.*') ? 'active' : '' }}"
                                        >
                                            My schedule
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="{{ route('employee.clients.index') }}"
                                            class="nav-link {{
                                                request()->routeIs('employee.clients.*')
                                                    ? 'active'
                                                    : ''
                                            }}"
                                        >
                                            Clients
                                        </a>
                                    </li>

                                @endif

                            @endauth

                        </ul>


                        <!-- Desna strana navigacije -->
                        <ul class="navbar-nav ms-auto">

                            @guest

                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            href="{{ route('login') }}"
                                        >
                                            Prijava
                                        </a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            href="{{ route('register') }}"
                                        >
                                            Registracija
                                        </a>
                                    </li>
                                @endif

                            @else

                            @if (Auth::user()->role === 'client')
                                <li class="nav-item me-2">
                                    <a
                                        href="{{ route('client.notifications.index') }}"
                                        class="nav-link position-relative"
                                        title="Notifications"
                                        aria-label="Notifications"
                                    >
                                        <i class="bi bi-bell fs-5"></i>

                                        @if (Auth::user()->unreadNotifications->count() > 0)
                                            <span
                                                class="position-absolute top-0 start-100
                                                    translate-middle badge rounded-pill bg-danger"
                                            >
                                                {{ Auth::user()->unreadNotifications->count() }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            @endif

                                <li class="nav-item dropdown">

                                    <a
                                        id="navbarDropdown"
                                        class="nav-link dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="navbarDropdown"
                                    >

                                        <a
                                            class="dropdown-item"
                                            href="{{ route('logout') }}"
                                            onclick="
                                                event.preventDefault();
                                                document
                                                    .getElementById(
                                                        'logout-form'
                                                    )
                                                    .submit();
                                            "
                                        >
                                            Odjava
                                        </a>

                                        <form
                                            id="logout-form"
                                            action="{{ route('logout') }}"
                                            method="POST"
                                            class="d-none"
                                        >
                                            @csrf
                                        </form>

                                    </div>

                                </li>

                            @endguest

                        </ul>

                    </div>

                </div>
            </nav>

        @endunless


        <main class="@yield('main-class', 'py-4')">
            @yield('content')
        </main>

    </div>

</body>
</html>