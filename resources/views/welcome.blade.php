<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Calculate the precise time between any two dates with beautiful visualizations.">

    <title>Distance Between Dates - Date Distance Calculator</title>

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
    class="antialiased bg-slate-950 text-slate-300 font-sans selection:bg-sky-500/30 selection:text-sky-200 overflow-x-hidden">

    <!-- Dynamic Cyber Background -->
    <div class="fixed inset-0 z-0 bg-slate-950">
        <!-- Animated Grid -->
        <div
            class="absolute inset-0 bg-grid-white/[0.02] bg-[size:50px_50px] [mask-image:linear-gradient(to_bottom,transparent,black,transparent)] animate-scan">
        </div>

        <!-- Glowing Orbs -->
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
                class="relative w-7 h-7 sm:w-8 sm:h-8 shrink-0 overflow-hidden rounded border border-white/10 bg-white/5 backdrop-blur-sm group-hover:border-sky-500/50 transition-all duration-500 shadow-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="w-full h-full object-contain p-1">
            </div>
            <div
                class="text-sm sm:text-base md:text-lg font-black text-white tracking-wider sm:tracking-widest uppercase leading-tight">
                DBD
            </div>
        </a>

        <div class="flex space-x-4 items-center">
            <a href="{{ url('/app') }}"
                class="text-sm font-mono tracking-wider text-slate-400 hover:text-sky-400 hover:animate-glitch transition-all">INITIALIZE_APP</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="min-h-screen flex flex-col justify-center items-center relative z-10 px-4 pt-20">

        <div class="text-center max-w-4xl mx-auto flex flex-col items-center">



            <!-- Tech Badge -->
            <div
                class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-mono tracking-widest uppercase mb-8 shadow-[0_0_15px_rgba(56,189,248,0.15)] animate-float-fast">
                <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                Date Distance Calculator v1.0
            </div>

            <h1
                class="text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight uppercase relative inline-block animate-flicker">
                Distance Between <br class="hidden md:block" />
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-indigo-400 to-sky-400 hover:animate-glitch cursor-crosshair">Dates</span>

                <!-- Corner brackets decoration -->
                <div class="absolute -top-4 -left-4 w-8 h-8 border-t-2 border-l-2 border-sky-500/30"></div>
                <div class="absolute -bottom-4 -right-4 w-8 h-8 border-b-2 border-r-2 border-sky-500/30"></div>
            </h1>

            <p class="text-lg md:text-xl text-slate-400 mb-12 max-w-2xl leading-relaxed font-light">
                A high-precision temporal calculator engineered to compute the exact span between dates.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 w-full sm:w-auto">
                <a href="{{ route('calculator') }}"
                    class="cyber-button-primary w-full sm:w-auto px-10 py-4 rounded-sm font-mono tracking-wider uppercase flex items-center justify-center gap-3 group">
                    LAUNCH_SYSTEM
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </a>
            </div>

        </div>
    </main>

    <footer
        class="border-t border-white/5 bg-slate-950/80 backdrop-blur-sm py-10 text-center z-20 relative mt-16 group">
        <div
            class="flex items-center justify-center gap-4 opacity-50 hover:opacity-100 transition-opacity duration-700">
            <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-sky-500/20"></div>

            <p class="text-slate-500 text-[10px] font-mono uppercase tracking-[0.3em]">
                Developed_by // <span class="text-sky-400 group-hover:text-sky-300 transition-colors">Abdur Rahman Emon</span>
            </p>
            <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-sky-500/20"></div>
        </div>
    </footer>
</body>

</html>