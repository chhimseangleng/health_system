<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Health Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js for dropdown and hamburger menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-900 text-white fixed ">

            <div class="p-1 flex justify-center">
                <img src="{{ asset('IMG/samaky.png') }}" alt="Profile"
                    class="rounded-full w-44 h-auto" loading="lazy">
                <p class="mt-2 text-lg font-semibold"></p>
            </div>

            <nav class="mt-4">
                <a href="{{ route("dashboard")}}"class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ trans('lang.dashboard') }}

                </a>
                <a href="{{ route('patients.index') }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21h-8a2 2 0 01-2-2V5a2 2 0 012-2h8a2 2 0 012 2v14a2 2 0 01-2 2zM5 21a2 2 0 01-2-2V5a2 2 0 012-2h2v18H5z" />
                    </svg>
                    Patient
                </a>
                <a href="{{ route("doctors.index")}}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Doctor
                </a>
                <div class="relative" x-data="{ open: false }" id="ticketDropdownWrapper">
                    <button id="ticketDropdownBtn"
                        class="flex items-center py-2 px-4 text-white hover:bg-gray-700 focus:outline-none"
                        type="button" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h-4" />
                        </svg>
                        Ticket
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="ticketDropdownMenu"
                        class="absolute left-0 mt-1 w-48 bg-gray-800 rounded-md shadow-lg hidden z-50" role="menu"
                        aria-orientation="vertical" aria-labelledby="ticketDropdownBtn">
                        <a href=""
                            class="block px-4 py-2 text-white hover:bg-gray-700 flex items-center gap-2"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h-4" />
                            </svg>
                            Create Ticket
                        </a>

                        <a href=""
                            class="block px-4 py-2 text-white hover:bg-gray-700 flex items-center gap-2"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h-4" />
                            </svg>
                            Show Ticket
                        </a>



                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dropdownBtn = document.getElementById('ticketDropdownBtn');
                        const dropdownMenu = document.getElementById('ticketDropdownMenu');

                        // Toggle dropdown on button click
                        dropdownBtn.addEventListener('click', function(e) {
                            e.stopPropagation(); // prevent event bubbling to document
                            dropdownMenu.classList.toggle('hidden');
                        });

                        // Close dropdown if clicking outside
                        document.addEventListener('click', function() {
                            if (!dropdownMenu.classList.contains('hidden')) {
                                dropdownMenu.classList.add('hidden');
                            }
                        });

                        // Optional: close dropdown on Escape key
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' && !dropdownMenu.classList.contains('hidden')) {
                                dropdownMenu.classList.add('hidden');
                            }
                        });
                    });
                </script>



                <a href="#" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2c0-1.104.896-2 2-2h2c1.104 0 2 .896 2 2v2m-6 0h6m-9-5h12M5 7h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                    </svg>
                    Report
                </a>
                {{-- <a href="#" class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Appointment
                </a> --}}
                <a href=""
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payment
                </a>

                <a href="{{ route('register') }}"
                    class="flex items-center py-2 px-4 text-white hover:bg-gray-700">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                    Add User
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1 bg-white dark:bg-gray-900">
            <!-- Navigation Bar -->
            <nav x-data="{ open: false }"
    class="sticky top-0 z-30 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                {{-- <a href="{{ route('dashboard') }}">
                                    <span class="text-2xl font-bold text-teal-500">HEALTH ADMIN</span>
                                </a> --}}
                            </div>

                            <!-- Navigation Links -->
                            {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <a href="{{ route('dashboard') }}" class="border-b-2 {{ request()->routeIs('dashboard') ? 'border-teal-500 text-gray-800' : 'border-transparent text-gray-500' }} hover:text-gray-700 hover:border-gray-300 pt-5">Dashboard</a>
                            </div> --}}
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="relative flex items-center space-x-3">
                                {{-- <nav class="p-4 border-b border-gray-300 dark:border-gray-700 flex justify-between items-center">
    <div>My Laravel App</div>
    <button id="darkModeToggle" class="px-3 py-1 border rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition">
        Dark Mode
    </button>
</nav> --}}

                                <!-- Theme Toggle Button -->
                                <button id="theme-toggle" onclick="toggleTheme()"
                                    class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                                    <!-- Sun Icon -->
                                    <svg id="icon-sun" class="w-6 h-6" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <!-- Moon Icon -->
                                    <svg id="icon-moon" class="w-6 h-6" style="display:none;" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- User Dropdown -->
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none transition-colors duration-200">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md shadow-lg z-10">
                                        <a href="{{ route('profile.edit') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">Log
                                                Out</a>
                                        </form>
                                    </div>
                                </div>

                                <!-- Language Dropdown -->
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open"
                                        class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                        <img src="https://flagcdn.com/24x18/us.png" class="inline w-5 h-4 mr-2"
                                            alt="English"
                                            x-show="!('locale' in localStorage) || localStorage.locale === 'en'">
                                        <img src="https://flagcdn.com/24x18/kh.png" class="inline w-5 h-4 mr-2"
                                            alt="Khmer" x-show="localStorage.locale === 'kh'">
                                        <span x-text="localStorage.locale === 'kh' ? 'Khmer' : 'English'"></span>
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded shadow-lg z-10">
                                        <a href="{{ route('lang.switch', 'en') }}"
                                            class="flex items-center px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <img src="https://flagcdn.com/24x18/us.png" class="inline w-5 h-4 mr-2"
                                                alt="English"> English
                                        </a>
                                        <a href="{{ route('lang.switch', 'kh') }}"
                                            class="flex items-center px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <img src="https://flagcdn.com/24x18/kh.png" class="inline w-5 h-4 mr-2"
                                                alt="Khmer"> Khmer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
            </nav>


</body>

</html>
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
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            setTheme(prefersDark ? 'dark' : 'light');
        }
    });
</script>


<script>
    const btn = document.getElementById('darkModeToggle');

    if (!btn) {
        // If button not found, don't run
        return;
    }

    // Initialize theme on page load
    if (localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        btn.textContent = 'Light Mode';
    } else {
        document.documentElement.classList.remove('dark');
        btn.textContent = 'Dark Mode';
    }

    btn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            btn.textContent = 'Light Mode';
        } else {
            localStorage.setItem('theme', 'light');
            btn.textContent = 'Dark Mode';
        }
    });
</script>
