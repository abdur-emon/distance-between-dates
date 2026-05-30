@extends('layouts.main')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs font-mono tracking-widest uppercase mb-6 shadow-[0_0_15px_rgba(56,189,248,0.15)] animate-float-fast">
                    <span class="w-2 h-2 bg-sky-400 animate-pulse"></span>
                    Terminal Access
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3 animate-flicker">
                    Age Calculator
                </h1>
                <p class="text-sky-500/70 font-mono tracking-widest uppercase text-sm">
                    Calculate the time between any two dates
                </p>
            </div>

            <!-- Main Card -->
            <div class="glass-panel p-8 rounded-sm relative group">
                <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-sky-500"></div>
                <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-sky-500"></div>
                <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-sky-500"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-sky-500"></div>
                
                <!-- Error Display -->
                <div id="error-container" class="hidden mb-6 p-4 bg-rose-500/10 border border-rose-500/30 rounded-sm animate-fade-in">
                    <div class="flex items-center gap-3 text-rose-400 font-mono text-xs uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span id="error-message">Error: Invalid date selection</span>
                    </div>
                </div>

                <!-- Form -->
                <form id="date-form" class="space-y-6">
                    <!-- Target Date -->
                    <x-date-input label="Target Date" id="target-date" name="target_date" :value="$targetDate"
                        :required="true" />

                    <!-- From Date Toggle -->
                    <div class="flex items-center space-x-3 mt-6">
                        <div class="relative flex items-center justify-center w-5 h-5 border border-sky-500/50 rounded-sm bg-slate-900 hover:border-sky-400 transition-colors">
                            <input type="checkbox" id="use-from-date"
                                class="absolute opacity-0 cursor-pointer w-full h-full peer"
                                {{ $fromDate ? 'checked' : '' }} />
                            <svg class="w-3 h-3 text-sky-400 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <label for="use-from-date" class="text-xs font-mono text-slate-400 uppercase tracking-widest cursor-pointer hover:text-sky-300 transition-colors">
                            Use custom origin date
                        </label>
                    </div>

                    <!-- From Date Input (conditionally shown) -->
                    <div id="from-date-container" class="{{ $fromDate ? 'block' : 'hidden' }}">
                        <x-date-input label="From Date" id="from-date" name="from_date" :value="$fromDate" />
                    </div>

                    <!-- Calculate Button -->
                    <button type="submit"
                        class="cyber-button-primary w-full py-4 rounded-sm mt-8 text-sm uppercase font-mono tracking-widest shadow-[0_0_15px_rgba(56,189,248,0.2)]">
                        PROCESS
                    </button>

                    <!-- Reset Button - Public feature -->
                    <div class="pt-4 mt-6 border-t border-sky-500/20 flex justify-end">
                        <button type="button" id="reset-button"
                            class="text-xs font-mono text-rose-500 hover:text-rose-400 uppercase tracking-widest px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 rounded-sm transition-all hover:shadow-[0_0_10px_rgba(244,63,94,0.3)]">
                            [RESET]
                        </button>
                    </div>
                </form>

                <!-- Results -->
                <div class="mt-8">
                    <x-result-display :result="$result" />
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-20 flex flex-col items-center gap-6 opacity-40 hover:opacity-100 transition-opacity duration-700 group">
                <div class="flex items-center gap-3 text-[9px] font-mono text-slate-600 tracking-widest uppercase">
                    <span class="px-2 py-0.5 rounded border border-slate-800 bg-slate-900/50">CMD</span>
                    <span class="text-sky-500/30">+</span>
                    <span class="px-2 py-0.5 rounded border border-slate-800 bg-slate-900/50">K</span>
                    <span class="ml-2 opacity-70">Focus_Input_Buffer</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-sky-500/20"></div>

                    <div class="text-[10px] font-mono uppercase tracking-[0.3em] text-slate-500">
                        Developed_by // <span class="text-sky-400 group-hover:text-sky-300 transition-colors">Abdur Rahman Emon</span>
                    </div>
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-sky-500/20"></div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Pass initial state to JavaScript -->
    <script>
        window.__INITIAL_STATE__ = {
            targetDate: @json($targetDate),
            fromDate: @json($fromDate),
            result: @json($result),
        };
    </script>
@endsection