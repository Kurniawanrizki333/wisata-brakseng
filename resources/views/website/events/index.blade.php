<x-website-layout title="Kalender Event">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .sb-font-display {
            font-family: 'Fraunces', serif;
            font-optical-sizing: auto;
        }

        .sb-font-body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sb-hero-bg {
            background:
                radial-gradient(60% 80% at 12% 0%, rgba(34, 139, 74, 0.10) 0%, rgba(34, 139, 74, 0) 60%),
                radial-gradient(50% 60% at 100% 10%, rgba(201, 169, 89, 0.08) 0%, rgba(201, 169, 89, 0) 60%),
                #FAFAF5;
        }

        .sb-card {
            border-radius: 1.5rem;
            transition: box-shadow .25s ease, transform .25s ease;
            box-shadow: 0 1px 2px rgba(20, 83, 45, 0.05);
        }

        .sb-card:hover {
            box-shadow: 0 16px 34px -14px rgba(20, 83, 45, 0.2);
            transform: translateY(-4px);
        }

        .sb-img-zoom {
            overflow: hidden;
        }

        .sb-img-zoom img {
            transition: transform .45s ease;
        }

        .sb-img-zoom:hover img {
            transform: scale(1.07);
        }

        .sb-pagination a,
        .sb-pagination span {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 0.75rem !important;
        }

        .sb-pagination [aria-current="page"] span {
            background-color: #047857 !important;
            border-color: #047857 !important;
            color: #fff !important;
        }

        .sb-pagination a:hover {
            background-color: #ecfdf5 !important;
            border-color: #34d399 !important;
        }
    </style>

    <section class="sb-font-body sb-hero-bg py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading title="Kalender Event" description="Agenda wisata desa, budaya, edukasi, dan UMKM." />

            @forelse ($events as $event)
                @if ($loop->first)
                    <div class="mt-10 grid gap-6 md:grid-cols-3">
                @endif

                    <a href="{{ route('event.show', $event) }}"
                        class="sb-card group overflow-hidden border border-stone-100 bg-white block focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                        <div class="sb-img-zoom relative">
                            <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" loading="lazy"
                                class="h-52 w-full object-cover">
                            <span
                                class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-700 shadow-sm">
                                {{ $event->start_date->translatedFormat('d M') }}
                            </span>
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                                {{ $event->start_date->translatedFormat('d F Y · H:i') }}</p>
                            <h2
                                class="sb-font-display mt-2 text-xl font-semibold text-emerald-950 group-hover:text-emerald-700 transition-colors">
                                {{ $event->title }}</h2>
                            <p class="mt-3 flex items-center gap-1.5 text-sm text-stone-500">
                                <svg class="h-4 w-4 flex-shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $event->location }}
                            </p>
                        </div>
                    </a>

                    @if ($loop->last)
                        </div>
                    @endif
            @empty
                <div
                    class="mt-10 flex flex-col items-center text-center gap-3 py-16 px-4 rounded-3xl border-2 border-dashed border-stone-200 bg-white/60">
                    <span
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </span>
                    <p class="sb-font-display text-lg font-semibold text-stone-700">Belum ada agenda mendatang</p>
                    <p class="text-sm text-stone-400">Event terbaru akan muncul di sini begitu dijadwalkan.</p>
                </div>
            @endforelse

            @if ($events->hasPages())
                <div class="mt-10 sb-pagination">{{ $events->links() }}</div>
            @endif
        </div>
    </section>
</x-website-layout>