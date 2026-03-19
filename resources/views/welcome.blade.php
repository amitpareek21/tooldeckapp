<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ToolDeckApp — Developer Tools, All in One Place</title>
    <meta name="description" content="ToolDeckApp is a fast, no-login toolkit for developers. Format JSON, analyze logs, and more — all in your browser." />
    <meta name="keywords" content="developer tools, JSON formatter, log analyzer, online utilities for developers, freemium dev tools" />
    <meta name="robots" content="index, follow" />
    <meta property="og:title" content="ToolDeckApp — Developer Tools, All in One Place" />
    <meta property="og:description" content="Browser-based developer tools. No login. No fluff. Just tools." />
    <meta property="og:type" content="website" />

    {{-- ⚡ Theme init — must run BEFORE CSS renders to prevent dark/light flash --}}
    <script>
        (function() {
            var saved = localStorage.getItem('tooldeckapp-theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{-- Google Fonts: DM Sans (body) + DM Mono (accents) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')

    <style>
        :root {
            --accent: #2563eb;
            --accent-light: #3b82f6;
            --accent-glow: rgba(37, 99, 235, 0.15);
        }

        * { font-family: 'DM Sans', sans-serif; }
        .font-mono { font-family: 'DM Mono', monospace; }

        /* ── Dot grid background ── */
        .dot-grid {
            background-image: radial-gradient(circle, rgba(99,102,241,0.18) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .dark .dot-grid {
            background-image: radial-gradient(circle, rgba(99,102,241,0.13) 1px, transparent 1px);
        }

        /* ── Hero gradient blob ── */
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Card hover lift ── */
        .tool-card {
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }
        .tool-card:hover {
            transform: translateY(-5px);
        }

        /* ── Coming soon card shimmer ── */
        @keyframes shimmer {
            0% { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }
        .shimmer-border {
            background: linear-gradient(90deg, transparent 25%, rgba(99,102,241,0.3) 50%, transparent 75%);
            background-size: 400px 100%;
            animation: shimmer 2.8s infinite linear;
        }

        /* ── FAQ accordion ── */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.25s ease;
        }
        .faq-answer.open {
            max-height: 300px;
        }
        .faq-icon {
            transition: transform 0.3s ease;
        }
        .faq-icon.rotated {
            transform: rotate(45deg);
        }

        /* ── Badge pulse ── */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .live-dot {
            animation: pulse-dot 1.8s ease infinite;
        }

        /* ── Page fade in ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.55s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.32s; }
        .delay-4 { animation-delay: 0.44s; }

        /* ── Theme toggle ── */
        #theme-toggle { transition: background 0.25s, border-color 0.25s; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
    </style>
</head>

<body class="bg-slate-50 dark:bg-[#0d1117] text-slate-800 dark:text-slate-200 transition-colors duration-300">

{{-- ════════════════════════════════════
     NAVBAR
════════════════════════════════════ --}}
<nav class="sticky top-0 z-50 bg-slate-50/80 dark:bg-[#0d1117]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-6xl mx-auto px-5 py-3.5 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 group" aria-label="ToolDeckApp Home">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm group-hover:bg-blue-700 transition-colors">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-white">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" fill="currentColor"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5" fill="currentColor" opacity=".45"/>
                </svg>
            </div>
            <span class="text-[15px] font-semibold tracking-tight text-slate-900 dark:text-white">
                ToolDeck<span class="text-blue-600">App</span>
            </span>
        </a>

        {{-- Right side --}}
        <div class="flex items-center gap-3">
            <a href="#tools"
               class="hidden sm:inline-flex text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors px-1">
                Tools
            </a>
            <a href="#faq"
               class="hidden sm:inline-flex text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors px-1">
                FAQ
            </a>
            <a href="#suggest"
               class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium px-3.5 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-blue-500 hover:text-blue-600 dark:hover:border-blue-500 dark:hover:text-blue-400 transition-all">
                Suggest a Tool
            </a>

            {{-- Dark/Light Toggle --}}
            <button id="theme-toggle" aria-label="Toggle dark mode"
                class="w-9 h-9 rounded-lg flex items-center justify-center border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-blue-400 dark:hover:border-blue-500 shadow-sm">
                {{-- Sun icon (shown in dark mode) --}}
                <svg id="icon-sun" class="hidden dark:block w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
                {{-- Moon icon (shown in light mode) --}}
                <svg id="icon-moon" class="block dark:hidden w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

<main>

{{-- ════════════════════════════════════
     HERO
════════════════════════════════════ --}}
<section class="relative overflow-hidden dot-grid min-h-[520px] flex items-center py-24">

    {{-- Gradient blobs --}}
    <div class="hero-blob w-[500px] h-[500px] bg-blue-400/20 dark:bg-blue-500/10 -top-32 -left-32"></div>
    <div class="hero-blob w-[380px] h-[380px] bg-indigo-400/15 dark:bg-indigo-500/10 top-10 right-0"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-5 text-center">

        {{-- Eyebrow --}}
        <p class="fade-up delay-1 inline-flex items-center gap-2 font-mono text-xs font-medium tracking-widest uppercase text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 px-3 py-1 rounded-full mb-5">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 live-dot"></span>
            No Login · Browser-Based · Freemium
        </p>

        {{-- h1 --}}
        <h1 class="fade-up delay-1 text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-slate-900 dark:text-white mb-5 max-w-3xl mx-auto">
            Every tool a developer<br class="hidden sm:block"/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">actually needs</span>
        </h1>

        {{-- Description (SEO) --}}
        <p class="fade-up delay-2 text-lg text-slate-600 dark:text-slate-400 max-w-xl mx-auto leading-relaxed mb-8">
            ToolDeckApp brings your most-used development utilities together in one clean,
            fast interface — no accounts, no ads, no clutter.
        </p>

        {{-- CTA buttons --}}
        <div class="fade-up delay-3 flex items-center justify-center gap-3 flex-wrap">
            <a href="#tools"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-lg shadow-blue-500/25 transition-all hover:shadow-blue-500/40 hover:-translate-y-0.5">
                Explore Tools
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="#suggest"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:border-blue-400 dark:hover:border-blue-600 transition-all hover:-translate-y-0.5">
                Suggest a Tool
            </a>
        </div>

        {{-- Floating stat pills --}}
        <div class="fade-up delay-4 mt-12 flex items-center justify-center gap-4 flex-wrap text-sm">
            <span class="flex items-center gap-1.5 text-slate-500 dark:text-slate-500">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                1 Tool Live
            </span>
            <span class="text-slate-300 dark:text-slate-700">|</span>
            <span class="flex items-center gap-1.5 text-slate-500 dark:text-slate-500">
                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                More Coming Soon
            </span>
            <span class="text-slate-300 dark:text-slate-700">|</span>
            <span class="flex items-center gap-1.5 text-slate-500 dark:text-slate-500">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Freemium Model
            </span>
        </div>

    </div>
</section>

{{-- ════════════════════════════════════
     TOOLS GRID
════════════════════════════════════ --}}
<section id="tools" class="py-20 max-w-6xl mx-auto px-5">

    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight mb-3">Developer Tools</h2>
        <p class="text-slate-500 dark:text-slate-400 max-w-md mx-auto text-base">Pick a tool and get to work. Everything runs in your browser — nothing is sent to a server.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- ── Tool Card: JSON Formatter (Live) ── --}}
        <article class="tool-card group relative bg-white dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 dark:hover:shadow-blue-500/5 hover:border-blue-300 dark:hover:border-blue-600/50">
            {{-- Icon --}}
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" class="text-blue-600 dark:text-blue-400">
                    <path d="M7 7c-1.1 0-2 .9-2 2v1c0 1.1-.9 2-2 2 1.1 0 2 .9 2 2v1c0 1.1.9 2 2 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M17 7c1.1 0 2 .9 2 2v1c0 1.1.9 2 2 2-1.1 0-2 .9-2 2v1c0 1.1-.9 2-2 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="1.2" fill="currentColor"/>
                    <circle cx="9" cy="12" r="1.2" fill="currentColor" opacity=".5"/>
                    <circle cx="15" cy="12" r="1.2" fill="currentColor" opacity=".5"/>
                </svg>
            </div>

            {{-- Status badge --}}
            <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 px-2 py-0.5 rounded-full mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 live-dot"></span> Live
            </span>

            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-1.5">JSON Formatter</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-5">
                Paste raw JSON and instantly format, validate, and minify it. Syntax highlighting included.
            </p>

            <a href="/json-formatter"
               class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:gap-2.5 transition-all">
                Open Tool
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </article>

        {{-- ── Tool Card: Log Analyzer (In Development) ── --}}
        <article class="relative bg-white dark:bg-slate-800/60 border border-violet-200 dark:border-violet-800/50 rounded-2xl p-6 shadow-sm overflow-hidden">

            {{-- Subtle progress shimmer bar at top --}}
            <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-violet-400 via-indigo-400 to-violet-400 shimmer-border"></div>

            <div class="w-12 h-12 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center mb-4">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" class="text-violet-500 dark:text-violet-400">
                    <path d="M4 6h16M4 10h10M4 14h12M4 18h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <circle cx="18" cy="16" r="3" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M20.5 18.5L22 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>

            {{-- Status badge: In Development --}}
            <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-violet-700 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/30 border border-violet-200 dark:border-violet-700 px-2 py-0.5 rounded-full mb-3">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                In Development
            </span>

            <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-1.5">Log Analyzer</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                Paste or upload log files to filter, search errors, highlight levels, and identify patterns fast.
            </p>

            {{-- Launch date pill --}}
            <div class="inline-flex items-center gap-1.5 text-xs font-medium text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 border border-violet-200 dark:border-violet-800 rounded-lg px-3 py-1.5">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Launching March 20th
            </div>
        </article>

        {{-- ── Coming Soon: Regex Tester ── --}}
        <article class="relative bg-slate-100/60 dark:bg-slate-800/30 border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-6 opacity-75">
            <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700/50 flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-slate-400 dark:text-slate-500">
                    <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-slate-500 dark:text-slate-500 bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-slate-600 px-2 py-0.5 rounded-full mb-3">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Coming Soon
            </span>

            <h3 class="text-base font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Regex Tester</h3>
            <p class="text-sm text-slate-400 dark:text-slate-500 leading-relaxed">
                Test and debug regular expressions with live match highlighting and group capture visualization.
            </p>
        </article>

        {{-- ── Coming Soon: Base64 Encoder/Decoder ── --}}
        <article class="relative bg-slate-100/60 dark:bg-slate-800/30 border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-6 opacity-75">
            <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700/50 flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-slate-400 dark:text-slate-500">
                    <path d="M8 7h8M8 12h5M8 17h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M16 14l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-slate-500 dark:text-slate-500 bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-slate-600 px-2 py-0.5 rounded-full mb-3">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Coming Soon
            </span>

            <h3 class="text-base font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Base64 Encoder / Decoder</h3>
            <p class="text-sm text-slate-400 dark:text-slate-500 leading-relaxed">
                Encode and decode Base64 strings — supports plain text, URLs, and file content.
            </p>
        </article>

        {{-- ── Coming Soon: JWT Debugger ── --}}
        <article class="relative bg-slate-100/60 dark:bg-slate-800/30 border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-6 opacity-75">
            <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700/50 flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-slate-400 dark:text-slate-500">
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M12 2v3M12 19v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M2 12h3M19 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
            </div>

            <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-slate-500 dark:text-slate-500 bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-slate-600 px-2 py-0.5 rounded-full mb-3">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Coming Soon
            </span>

            <h3 class="text-base font-semibold text-slate-500 dark:text-slate-400 mb-1.5">JWT Debugger</h3>
            <p class="text-sm text-slate-400 dark:text-slate-500 leading-relaxed">
                Decode and inspect JWT tokens. View header, payload, and verify signatures instantly.
            </p>
        </article>

        {{-- ── Coming Soon: Cron Expression Parser ── --}}
        <article class="relative bg-slate-100/60 dark:bg-slate-800/30 border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-6 opacity-75">
            <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-700/50 flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-slate-400 dark:text-slate-500">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <circle cx="12" cy="16" r="2" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 13v1M12 19v1M9 16H8M16 16h-1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>

            <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-slate-500 dark:text-slate-500 bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-slate-600 px-2 py-0.5 rounded-full mb-3">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Coming Soon
            </span>

            <h3 class="text-base font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Cron Expression Parser</h3>
            <p class="text-sm text-slate-400 dark:text-slate-500 leading-relaxed">
                Translate cron expressions into plain English and preview the next run times.
            </p>
        </article>

    </div>
</section>

{{-- ════════════════════════════════════
     FEATURES STRIP
════════════════════════════════════ --}}
<section class="bg-white dark:bg-slate-800/40 border-y border-slate-200 dark:border-slate-700/50 py-14">
    <div class="max-w-6xl mx-auto px-5">

        <h2 class="text-center text-2xl font-bold text-slate-900 dark:text-white mb-10 tracking-tight">
            Why developers choose ToolDeckApp
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="flex flex-col items-center text-center gap-3 p-5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Blazing Fast</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Everything runs in your browser. Zero round-trips to a server.</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 p-5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">No Login Required</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">No accounts. No email. Just open a tool and start using it.</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 p-5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="w-11 h-11 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Freemium Model</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Core tools are free. Unlock advanced features with a plan that fits your workflow.</p>
            </div>

            <div class="flex flex-col items-center text-center gap-3 p-5 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="w-11 h-11 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Built by Devs</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Tools designed around real developer workflows, not assumptions.</p>
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════════════
     FAQ
════════════════════════════════════ --}}
<section id="faq" class="py-20 max-w-3xl mx-auto px-5">

    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight mb-3">Frequently Asked Questions</h2>
        <p class="text-slate-500 dark:text-slate-400 text-base">Got a question? We probably answered it here.</p>
    </div>

    <div class="space-y-3" id="faq-list">

        @php
        $faqs = [
            [
                'q' => 'What is ToolDeckApp?',
                'a' => 'ToolDeckApp is a collection of free, browser-based developer utilities. It brings commonly-used tools like JSON formatters and log analyzers into one fast, clean interface — so you spend less time searching for tools and more time building.'
            ],
            [
                'q' => 'Is ToolDeckApp free to use?',
                'a' => 'ToolDeckApp uses a freemium model. Core features of each tool are available for free. Advanced features — like higher usage limits, export options, and history — are unlocked with a paid plan.'
            ],
            [
                'q' => 'Do I need to create an account?',
                'a' => 'No. ToolDeckApp requires zero sign-up. Just open a tool and start using it. Your data never leaves your browser.'
            ],
            [
                'q' => 'Is my data safe? Does ToolDeckApp store it?',
                'a' => 'Your data stays entirely in your browser. ToolDeckApp tools process everything client-side and do not send your content to any server. Nothing is stored or logged.'
            ],
            [
                'q' => 'What tools are currently available?',
                'a' => 'Right now we have the JSON Formatter (live). The Log Analyzer is currently in development and launching on March 20th. More tools — including a Regex Tester, Base64 Encoder, JWT Debugger, and Cron Expression Parser — are actively in the pipeline.'
            ],
            [
                'q' => 'How often are new tools added?',
                'a' => 'We ship new tools regularly. You can suggest a tool using the form below — community requests are prioritised.'
            ],
            [
                'q' => 'Can I suggest a tool that is missing?',
                'a' => 'Absolutely. Use the "Suggest a Tool" form below. We review every suggestion and prioritise based on demand and usefulness.'
            ],
        ];
        @endphp

        @foreach($faqs as $i => $faq)
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl overflow-hidden">
            <button
                class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left"
                aria-expanded="false"
                aria-controls="faq-answer-{{ $i }}"
            >
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $faq['q'] }}</h3>
                <svg class="faq-icon flex-shrink-0 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
            <div class="faq-answer px-5" id="faq-answer-{{ $i }}" role="region">
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed pb-4">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach

    </div>
</section>

{{-- ════════════════════════════════════
     SUGGEST A TOOL CTA
════════════════════════════════════ --}}
<section id="suggest" class="py-16 px-5">
    <div class="max-w-2xl mx-auto text-center bg-gradient-to-br from-blue-600 to-indigo-600 rounded-3xl p-10 shadow-xl shadow-blue-500/20 relative overflow-hidden">
        {{-- Decorative blobs --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10 pointer-events-none"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 rounded-full bg-white/10 pointer-events-none"></div>

        <div class="relative z-10">
            <p class="font-mono text-xs font-medium text-blue-200 tracking-widest uppercase mb-3">Community Driven</p>
            <h2 class="text-2xl font-bold text-white mb-3 tracking-tight">Missing a tool?</h2>
            <p class="text-blue-100 text-sm leading-relaxed mb-7 max-w-sm mx-auto">
                Tell us what you need. We read every suggestion and build based on what developers actually use.
            </p>
            <a href="/cdn-cgi/l/email-protection#6f070a0303002f1b0000030b0a0c040e1f1f410c0002501c1a0d050a0c1b523b0000034f3c1a08080a1c1b060001" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-semibold text-sm rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                Suggest a Tool
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

</main>

{{-- ════════════════════════════════════
     FOOTER
════════════════════════════════════ --}}
<footer class="border-t border-slate-200 dark:border-slate-800 py-10 mt-4">
    <div class="max-w-6xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-4">

        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-md bg-blue-600 flex items-center justify-center">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" class="text-white">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" fill="currentColor"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5" fill="currentColor" opacity=".7"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5" fill="currentColor" opacity=".45"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-400">ToolDeck<span class="text-blue-600">App</span></span>
        </div>

        <p class="text-xs text-slate-400 dark:text-slate-600 font-mono">
            &copy; {{ date('Y') }} ToolDeckApp &mdash; Built with 🩶 for developers, by Amit Pareek.
        </p>

        <nav class="flex items-center gap-4" aria-label="Footer navigation">
            <a href="#tools" class="text-xs text-slate-500 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Tools</a>
            <a href="#faq" class="text-xs text-slate-500 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">FAQ</a>
            <a href="mailto:amitpareekofficial@gmail.com" class="text-xs text-slate-500 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Contact</a>
        </nav>
    </div>
</footer>

{{-- ════════════════════════════════════
     JS: Dark mode toggle + FAQ accordion
════════════════════════════════════ --}}
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
    // ── Dark / Light Toggle ──────────────────────────────
    // (theme class already applied in <head> to avoid flash)
    const html = document.documentElement;
    document.getElementById('theme-toggle').addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('tooldeckapp-theme', html.classList.contains('dark') ? 'dark' : 'light');
    });

    // ── FAQ Accordion ────────────────────────────────────
    document.querySelectorAll('.faq-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            const answer = btn.nextElementSibling;
            const icon   = btn.querySelector('.faq-icon');
            const isOpen = answer.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
            document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('rotated'));
            document.querySelectorAll('.faq-trigger').forEach(b => b.setAttribute('aria-expanded', 'false'));

            // Open clicked (if it wasn't already open)
            if (!isOpen) {
                answer.classList.add('open');
                icon.classList.add('rotated');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
</script>

</body>
</html>
        