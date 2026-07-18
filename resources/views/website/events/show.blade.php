<x-website-layout :title="$event->title">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .sb-font-display {
            font-family: 'Fraunces', serif;
            font-optical-sizing: auto;
        }

        .sb-font-body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sb-hero-overlay {
            background: linear-gradient(0deg, rgba(6, 30, 20, 0.85) 0%, rgba(6, 30, 20, 0.15) 45%, rgba(6, 30, 20, 0) 70%);
        }
    </style>

    <article class="sb-font-body py-10 bg-[#FAFAF5]">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-1.5 text-xs font-semibold text-stone-400">
                <a href="{{ route('event.index') }}" class="hover:text-emerald-700 transition-colors">Kalender Event</a>
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-stone-600 truncate max-w-[220px]">{{ $event->title }}</span>
            </nav>

            <!-- Hero dengan overlay judul -->
            <div class="relative h-[380px] w-full overflow-hidden rounded-3xl">
                <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="h-full w-full object-cover">
                <div class="sb-hero-overlay absolute inset-0"></div>
                <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-700 shadow-sm">
                        {{ $event->start_date->translatedFormat('d F Y · H:i') }}
                    </span>
                    <h1 class="sb-font-display mt-3 text-3xl sm:text-4xl font-semibold text-white leading-tight">
                        {{ $event->title }}</h1>
                </div>
            </div>

            <div
                class="mt-6 flex items-center gap-2 rounded-2xl border border-stone-100 bg-white px-5 py-4 shadow-sm shadow-emerald-900/5">
                <svg class="h-5 w-5 flex-shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <p class="text-sm font-bold text-stone-700">{{ $event->location }}</p>
            </div>

            <div class="mt-8 whitespace-pre-line text-[15px] leading-8 text-stone-700">{{ $event->description }}</div>

            <a href="{{ route('event.index') }}"
                class="mt-10 inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Kalender Event
            </a>
        </div>
    </article>
</x-website-layout>