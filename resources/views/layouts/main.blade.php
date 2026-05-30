<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Age Calculator. Calculate the precise time between any two dates with beautiful visualizations.">

    <title>{{ $title ?? 'Age Calculator — Calculate the time between any two dates' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body
    class="antialiased bg-slate-950 text-slate-300 font-sans selection:bg-sky-500/30 selection:text-sky-200 overflow-x-hidden dark relative">

    <!-- Dynamic Cyber Background -->
    <div class="fixed inset-0 z-0 bg-slate-950 pointer-events-none">
        <div
            class="absolute inset-0 bg-grid-white/[0.02] bg-[size:50px_50px] [mask-image:linear-gradient(to_bottom,transparent,black,transparent)] animate-scan">
        </div>
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 bg-sky-600/20 rounded-full blur-[120px] mix-blend-screen animate-pulse-glow">
        </div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] mix-blend-screen animate-pulse-glow"
            style="animation-delay: 1.5s;"></div>
    </div>

    <!-- Navigation Area -->
    <nav
        class="absolute top-0 w-full px-6 py-4 flex justify-between items-center z-20 border-b border-white/5 bg-slate-950/50 backdrop-blur-md">
        <a href="/" class="flex items-center gap-3 sm:gap-5 group">
            <div
                class="relative w-7 h-7 sm:w-8 sm:h-8 shrink-0 overflow-hidden rounded border border-white/10 bg-white/5 backdrop-blur-sm group-hover:border-sky-500/50 transition-all duration-500">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="w-full h-full object-contain p-1">
            </div>
            <div
                class="text-sm sm:text-base md:text-lg font-black text-white tracking-wider sm:tracking-widest uppercase leading-tight">
                Age Calculator
            </div>
        </a>

        <div class="flex space-x-4 items-center">
            <!-- Auth links removed -->
        </div>
    </nav>

    <div class="relative z-10 pt-20 pb-10">
        @yield('content')
    </div>
</body>

</html>