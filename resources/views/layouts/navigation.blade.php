<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Samaky Health - Admin Dashboard</title>

    <!-- Modern Sans-serif Font for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Khmer Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js for dropdown and hamburger menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Support Styles -->
    <style>
        /* Apply fonts based on locale */
        @if (app()->getLocale() == 'kh')
            body {
                font-family: 'Noto Sans Khmer', 'Kantumruy Pro', 'Khmer OS', 'Khmer Sangam MN', 'Arial Unicode MS', sans-serif !important;
            }
        @else
            body {
                font-family: 'Inter', 'Noto Sans Khmer', 'Kantumruy Pro', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
            }
        @endif
    </style>
</head>

<body class="bg-gray-50 text-gray-900 font-sans">
    <div class="flex">
        <!-- Modern Sidebar -->
        <div class="w-64 h-screen bg-white shadow-lg fixed">
            <!-- Header with Logo -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <!-- Logo -->
                    <div class="relative">
                        <a href="{{ route('dashboard') }}" class="block">
                            <img src="{{ asset('IMG/samaky.png') }}" alt="icon" class="w-10 h-10 rounded-full object-cover">
                        </a>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">Samaky Health</h1>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="p-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search for anything..."
                           class="w-full pl-10 pr-4 py-2 bg-purple-50 border-0 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-200">
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="px-4 space-y-2">
                <!-- Dashboard (Active) -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-3 text-white bg-purple-500 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Patients -->
                <a href="{{ route('patients.index') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Patients</span>
                </a>

                  <!-- WorkSpace -->
                  <a href="{{ route('workspace.index') }}"
                  class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                   <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                   </svg>
                   <span>WorkSpace</span>
               </a>

                <!-- Doctors -->
                <a href="{{ route('doctors.index') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Doctors</span>
                </a>

                <!-- Add User -->
                <a href="{{ route('register') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span>Add User</span>
                </a>

                <!-- Documents -->
                <a href="#"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Documents</span>
                </a>

                <!-- Main Overview -->
                <a href="#"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Main Overview</span>
                </a>

                <!-- Statistics -->
                <a href="#"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Statistics</span>
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100">
                <!-- Settings -->
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200 mb-2">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>

                <!-- Help -->
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200 mb-4">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Help</span>
                </a>

                <!-- User Profile -->
                <div class="flex items-center px-4 py-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-purple-600 font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1 bg-gray-50">
            <!-- Top Navigation Bar -->
            <nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left side -->
                        <div class="flex items-center">
                            <h2 class="text-xl font-semibold text-gray-800">
                                Dashboard
                            </h2>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <!-- Theme Toggle -->
                            <button id="theme-toggle" onclick="toggleTheme()"
                                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors duration-200">
                                <svg id="icon-sun" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <svg id="icon-moon" class="w-5 h-5" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </button>


                            <!-- Language Dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                    @if (app()->getLocale() == 'kh')
                                        <img src="https://flagcdn.com/24x18/kh.png" class="w-5 h-4 mr-2" alt="Khmer">
                                        <span class="text-sm">{{ trans('lang.khmer') }}</span>
                                    @else
                                        <img src="https://flagcdn.com/24x18/us.png" class="w-5 h-4 mr-2" alt="English">
                                        <span class="text-sm">{{ trans('lang.english') }}</span>
                                    @endif
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-10">

                               <form action="{{ route('locale.change') }}" method="POST">
                                   @csrf

                                   <button type="submit" name="locale" value="en"
                                           class="flex items-center w-full px-4 py-2 text-sm hover:bg-gray-50 {{ app()->getLocale() == 'en' ? 'bg-gray-100' : '' }}">
                                       <img src="https://flagcdn.com/24x18/us.png" class="w-5 h-4 mr-2" alt="English"> English
                                   </button>

                                   <button type="submit" name="locale" value="kh"
                                           class="flex items-center w-full px-4 py-2 text-sm hover:bg-gray-50 {{ app()->getLocale() == 'kh' ? 'bg-gray-100' : '' }}">
                                       <img src="https://flagcdn.com/24x18/kh.png" class="w-5 h-4 mr-2" alt="Khmer"> Khmer
                                   </button>
                               </form>


                           </div>

                            </div>

                            <!-- User Dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                    <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log Out</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById('icon-sun').style.display = isDark ? 'none' : '';
            document.getElementById('icon-moon').style.display = isDark ? '' : 'none';
        }

        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('theme', theme);
            updateThemeIcon();
        }

        function toggleTheme() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                setTheme(savedTheme);
            } else {
                setTheme('light');
            }
        });
    </script>


</body>
</html>
