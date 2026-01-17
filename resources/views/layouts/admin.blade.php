<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="h-full">

    <!-- Navbar -->
    <nav class="navbar fixed top-0 z-50 w-full h-14 flex items-center px-4">
        <button id="toggleSidebar" class="p-2" aria-label="Toggle sidebar">
            <svg class="w-6 h-6 text-gray-700 transition-transform duration-300" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="flex items-center ml-4">
            <div
                class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                <span class="text-white font-bold text-sm">V</span>
            </div>
            <span
                class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 text-xl">Vistana</span>
            {{-- <span class="ml-2 text-xs px-2 py-1 bg-indigo-50 text-indigo-600 rounded-full font-medium">Admin</span>
            --}}
        </div>

        <div class="ml-auto flex items-center space-x-4">
            <!-- Notifications -->
            <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification"
                class="relative p-2 rounded-full hover:bg-gray-100 transition-colors duration-200" type="button">
                <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z" />
                </svg>
                @if (Auth::user()->unreadNotifications->count() > 0)
                    <div class="notification-badge">{{ Auth::user()->unreadNotifications->count() }}</div>
                @endif
            </button>

            <!-- User dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 focus:outline-none transition-all duration-300 ease-out shadow-sm hover:shadow">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-3">
                                <span
                                    class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->roles->first()->name ?? 'User' }}
                                </div>
                            </div>
                            <div class="ms-3">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 py-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        {{-- Authentication --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                class="flex items-center gap-3 py-3 text-red-600 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>

        <!-- Mobile menu button (hidden on desktop) -->
        <button id="mobileMenuButton" class="md:hidden ml-4 p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    <!-- Notifications Dropdown -->
    <div id="dropdownNotification" class="dropdown-content z-50 hidden w-full max-w-sm absolute right-4 top-14 mt-2"
        aria-labelledby="dropdownNotificationButton">
        <div
            class="block px-4 py-3 font-semibold text-gray-800 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <span>Notifications</span>
                @if (Auth::user()->unreadNotifications->count() > 0)
                    <span class="text-xs px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full">
                        {{ Auth::user()->unreadNotifications->count() }} new
                    </span>
                @endif
            </div>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @if (Auth::user()->unreadNotifications->count() > 0)
                @foreach (Auth::user()->unreadNotifications as $notification)
                    <a href="{{ route('readnotification', $notification) }}"
                        class="flex px-4 py-3 hover:bg-gray-50 border-b border-gray-100 transition-colors duration-200">
                        <div class="flex-shrink-0 mt-1">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="w-full ps-3">
                            <div class="text-gray-700 text-sm mb-1">{{ $notification->data['message'] }}</div>
                            <div class="text-xs text-blue-500 font-medium">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="px-4 py-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <p>No new notifications</p>
                </div>
            @endif
        </div>
        @if (Auth::user()->unreadNotifications->count() > 0)
            <a href="{{ route('readallnotification') }}"
                class="block py-3 font-medium text-center text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border-t border-gray-200 transition-all duration-200 flex items-center justify-center gap-2"
                onclick="event.preventDefault(); document.getElementById('markAllReadForm').submit();">
                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Mark all as read
            </a>
            <form id="markAllReadForm" action="{{ route('readallnotification') }}" method="Get" class="hidden">
                @csrf
            </form>
        @endif
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed top-14 left-0 h-[calc(100vh-3.5rem)] overflow-y-auto">
        <div class="p-4">
            <div class="mb-6 px-2 hidden md:block">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main Menu</div>
            </div>
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5m4 0h5a1 1 0 001-1V10" />
                        </svg>
                        <span class="nav-text font-medium">Home</span>
                        @if (Route::currentRouteName() == 'dashboard')
                            <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                        @endif
                    </a>
                </li>

                <!-- Reservations -->
                @can('reservation-list')
                    <li>
                        <a href="{{ route('reservations.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'reservations.index' || str_starts_with(Route::currentRouteName(), 'reservations.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="nav-text font-medium">Reservations</span>
                            @if (Route::currentRouteName() == 'reservations.index' || str_starts_with(Route::currentRouteName(), 'reservations.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan

                <!-- Users -->
                <li>
                    @can('list_user')
                            <a href="{{ route('users.index') }}"
                                class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'users.index' || str_starts_with(Route::currentRouteName(), 'users.') ? 'active' : '' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-1a4 4 0 00-5-3.87M9 20H4v-1a4 4 0 015-3.87m6-7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="nav-text font-medium">Users</span>
                                @if (Route::currentRouteName() == 'users.index' || str_starts_with(Route::currentRouteName(), 'users.'))
                                    <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                                @endif
                            </a>
                        </li>
                    @endcan


                <!-- Rooms -->
                @can('room-list')
                    <li>
                        <a href="{{ route('rooms.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'rooms.index' || str_starts_with(Route::currentRouteName(), 'rooms.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 10h18" />
                            </svg>
                            <span class="nav-text font-medium">Rooms</span>
                            @if (Route::currentRouteName() == 'rooms.index' || str_starts_with(Route::currentRouteName(), 'rooms.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan

                <!-- Room Types -->
                @can('view room_types')
                    <li>
                        <a href="{{ route('room_types.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'room_types.index' || str_starts_with(Route::currentRouteName(), 'room_types.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6h6v6H4zM14 6h6v6h-6zM4 16h6v6H4zM14 16h6v6h-6z" />
                            </svg>
                            <span class="nav-text font-medium">Room Types</span>
                            @if (Route::currentRouteName() == 'room_types.index' || str_starts_with(Route::currentRouteName(), 'room_types.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan

                <!-- Services -->
                @can('view services')
                    <li>
                        <a href="{{ route('serv.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'serv.index' || str_starts_with(Route::currentRouteName(), 'serv.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                            </svg>
                            <span class="nav-text font-medium">Services</span>
                            @if (Route::currentRouteName() == 'serv.index' || str_starts_with(Route::currentRouteName(), 'serv.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan

                <!-- Invoices -->
                @can('view invoices')
                    <li>
                        <a href="{{ route('invoices.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'invoices.index' || str_starts_with(Route::currentRouteName(), 'invoices.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="nav-text font-medium">Invoices</span>
                            @if (Route::currentRouteName() == 'invoices.index' || str_starts_with(Route::currentRouteName(), 'invoices.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan

                <!-- Roles -->
                @can('role-list')
                    <li>
                        <a href="{{ route('roles.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'roles.index' || str_starts_with(Route::currentRouteName(), 'roles.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z" />
                            </svg>
                            <span class="nav-text font-medium">Roles</span>
                            @if (Route::currentRouteName() == 'roles.index' || str_starts_with(Route::currentRouteName(), 'roles.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan

                <!-- Ratings -->
                @can('rating-list')
                    <li>
                        <a href="{{ route('ratings.index') }}"
                            class="flex items-center gap-3 p-3 {{ Route::currentRouteName() == 'ratings.index' || str_starts_with(Route::currentRouteName(), 'ratings.') ? 'active' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.01 6.18h6.49l-5.25 3.81 2.01 6.18L12 15.27l-5.21 3.83 2.01-6.18-5.25-3.81h6.49z" />
                            </svg>
                            <span class="nav-text font-medium">Ratings</span>
                            @if (Route::currentRouteName() == 'ratings.index' || str_starts_with(Route::currentRouteName(), 'ratings.'))
                                <span class="absolute right-3 w-2 h-2 bg-white rounded-full"></span>
                            @endif
                        </a>
                    </li>
                @endcan
            </ul>


        </div>
    </aside>

    <!-- Content -->
    <div id="content" class="content pt-20 p-6">
        <div class="content-wrapper content-area">


            <!-- Main Content -->
            <div class="content-inner">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <script>
        // Sidebar toggle functionality
        const toggle = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Load sidebar state from localStorage
        if (localStorage.getItem('sidebar') === 'collapsed') {
            sidebar.classList.add('collapsed');
            content.classList.add('expanded');
        }

        // Toggle sidebar on button click
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');

            localStorage.setItem(
                'sidebar',
                sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded'
            );
        });

        // Mobile sidebar functionality
        if (mobileMenuButton && sidebarOverlay) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
                sidebarOverlay.classList.toggle('hidden');
            });

            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.add('hidden');
            });
        }

        // Notification dropdown functionality
        const notificationButton = document.getElementById('dropdownNotificationButton');
        const notificationDropdown = document.getElementById('dropdownNotification');

        if (notificationButton) {
            notificationButton.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }

        // Active menu highlighting
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.sidebar a');

            menuLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath ||
                    currentPath.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });
        });

        // Add smooth transitions to all interactive elements
        document.querySelectorAll('a, button').forEach(element => {
            element.style.transition = 'all 0.2s ease-in-out';
        });
    </script>

</body>

</html>