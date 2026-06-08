<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Biocamp Academy') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @livewireStyles
</head>
<body class="gradient-bg-purple min-h-screen text-slate-100 flex flex-col antialiased">
    
    <!-- Immersive Dynamic Navbar -->
    <header class="sticky top-0 z-50 glass-panel border-b border-slate-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <i class="fas fa-dna text-violet-400 text-2xl animate-pulse-subtle"></i>
                        <span class="gradient-text font-heading text-xl font-extrabold tracking-tight">BIOCAMP</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-8">
                    <a href="/" class="text-sm font-medium {{ request()->is('/') ? 'text-violet-400' : 'text-slate-300 hover:text-slate-100' }} transition-colors duration-200">
                        Inicio
                    </a>
                    <a href="/catalog" class="text-sm font-medium {{ request()->is('catalog') ? 'text-violet-400' : 'text-slate-300 hover:text-slate-100' }} transition-colors duration-200">
                        Catálogo
                    </a>
                    
                    @auth
                        @if(auth()->user()->hasRole('student') || auth()->user()->hasRole('admin'))
                            <a href="/my-courses" class="text-sm font-medium {{ request()->is('my-courses') ? 'text-violet-400' : 'text-slate-300 hover:text-slate-100' }} transition-colors duration-200">
                                Mis Cursos
                            </a>
                        @endif
                        <a href="/subscription" class="text-sm font-medium {{ request()->is('subscription') ? 'text-violet-400' : 'text-slate-300 hover:text-slate-100' }} transition-colors duration-200">
                            Planes
                        </a>
                    @endauth
                </nav>

                <!-- Auth Buttons & Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="/admin/dashboard" class="hidden sm:inline-flex items-center px-3 py-1.5 border border-violet-500 text-xs font-semibold rounded-lg text-violet-400 bg-violet-950/20 hover:bg-violet-950/40 hover:text-violet-300 transition-all duration-200">
                                <i class="fas fa-lock-open mr-1.5"></i> Panel Admin
                            </a>
                        @endif

                        <div class="relative flex items-center space-x-3" x-data="{ open: false }">
                            <span class="text-sm text-slate-300 font-medium hidden sm:inline-block">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>
                            <button @click="open = !open" class="flex text-sm border-2 border-violet-500/50 rounded-full focus:outline-none focus:border-violet-400 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" />
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" class="absolute right-0 top-10 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-800 shadow-2xl py-1 z-50 text-slate-200" style="display: none;">
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="/admin/dashboard" class="block px-4 py-2 text-xs hover:bg-slate-800 transition-colors">
                                        <i class="fas fa-lock mr-2"></i> Panel Admin
                                    </a>
                                @endif
                                <a href="/user/profile" class="block px-4 py-2 text-xs hover:bg-slate-800 transition-colors">
                                    <i class="fas fa-user-cog mr-2"></i> Mi Cuenta
                                </a>
                                <div class="border-t border-slate-800 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-rose-400 hover:bg-rose-950/20 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-sm font-medium text-slate-300 hover:text-slate-100 transition duration-200">
                            Iniciar Sesión
                        </a>
                        <a href="/register" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-violet-600 hover:bg-violet-500 shadow-lg shadow-violet-600/20 active:scale-95 transition-all duration-200">
                            Regístrate
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-900 py-8 mt-12 text-slate-500">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Biocamp Academy. Todos los derechos reservados.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
