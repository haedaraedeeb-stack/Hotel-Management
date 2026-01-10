<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar {
            width: 16rem;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 4.5rem;
        }

        .content {
            margin-left: 16rem;
            transition: margin-left 0.3s ease;
        }

        .content.expanded {
            margin-left: 4.5rem;
        }

        .nav-text {
            transition: opacity 0.2s ease, width 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b shadow-sm h-14 flex items-center px-4">
        <button id="toggleSidebar" class="p-2 rounded hover:bg-gray-100">
            <!-- menu icon -->
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <span class="ml-4 font-bold text-indigo-700">Vistana</span>
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        @if (auth()->check())
                            <div>{{ auth()->user()->name }}</div>
                        @endif
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed top-14 left-0 h-[calc(100vh-3.5rem)] bg-white border-r overflow-y-auto">

        <ul class="p-3 space-y-1 font-medium">

            {{-- Dashboard --}}
            @hasanyrole('admin|manager|receptionist')
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5m4 0h5a1 1 0 001-1V10" />
                        </svg>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Reservations --}}
            @hasanyrole('admin|manager|receptionist')
                <li>
                    <a href="{{ route('reservations.index') }}"
                        class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="nav-text">Reservations</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Users --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-1a4 4 0 00-5-3.87M9 20H4v-1a4 4 0 015-3.87m6-7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="nav-text">Users</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Rooms --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 10h18" />
                        </svg>
                        <span class="nav-text">Rooms</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Room Types --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('room_types.index') }}"
                        class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h6v6H4zM14 6h6v6h-6zM4 16h6v6H4zM14 16h6v6h-6z" />
                        </svg>
                        <span class="nav-text">Room Types</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Services --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('serv.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                        </svg>
                        <span class="nav-text">Services</span>
                    </a>
                </li>
            @endhasanyrole
            {{-- Invoices --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="nav-text">Invoices</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Roles --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('roles.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z" />
                        </svg>
                        <span class="nav-text">Roles</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Ratings --}}
            @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('ratings.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.01 6.18h6.49l-5.25 3.81 2.01 6.18L12 15.27l-5.21 3.83 2.01-6.18-5.25-3.81h6.49z" />
                        </svg>
                        <span class="nav-text">Ratings</span>
                    </a>
                </li>
            @endhasanyrole

        </ul>
    </aside>

    <!-- Content -->
    <div id="content" class="content pt-20 p-4">
        @yield('content')
    </div>

    <script>
        const toggle = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        if (localStorage.getItem('sidebar') === 'collapsed') {
            sidebar.classList.add('collapsed');
            content.classList.add('expanded');
        }

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');

            localStorage.setItem(
                'sidebar',
                sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded'
            );
        });
    </script>

</body>

</html>
