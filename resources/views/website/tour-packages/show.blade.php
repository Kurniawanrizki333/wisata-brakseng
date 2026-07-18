<x-website-layout :title="$tourPackage->name">

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

        .sb-card {
            border-radius: 1.5rem;
            box-shadow: 0 1px 2px rgba(20, 83, 45, 0.05);
        }
    </style>

    <article class="sb-font-body py-10 bg-[#FAFAF5]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-1.5 text-xs font-semibold text-stone-400">
                <a href="{{ route('paket-wisata.index') }}" class="hover:text-emerald-700 transition-colors">Paket
                    Wisata</a>
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-stone-600 truncate max-w-[220px]">{{ $tourPackage->name }}</span>
            </nav>

            <div class="grid gap-10 lg:grid-cols-[1fr_360px]">
                <div>
                    <!-- Hero dengan overlay judul + durasi -->
                    <div class="relative h-[380px] w-full overflow-hidden rounded-3xl">
                        <img src="{{ $tourPackage->cover_image_url }}" alt="{{ $tourPackage->name }}"
                            class="h-full w-full object-cover">
                        <div class="sb-hero-overlay absolute inset-0"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-white/95 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-700 shadow-sm">
                                {{ $tourPackage->duration }}
                            </span>
                            <h1
                                class="sb-font-display mt-3 text-3xl sm:text-4xl font-semibold text-white leading-tight">
                                {{ $tourPackage->name }}</h1>
                        </div>
                    </div>

                    <div class="mt-8 whitespace-pre-line text-[15px] leading-8 text-stone-700">
                        {{ $tourPackage->description }}</div>

                    @if ($tourPackage->facility)
                        <div class="mt-10 sb-card border border-stone-100 bg-white p-6">
                            <h2 class="sb-font-display text-xl font-semibold text-emerald-950 mb-4">Fasilitas</h2>
                            <div class="whitespace-pre-line text-sm leading-7 text-stone-700">{{ $tourPackage->facility }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sticky booking card, konsisten dengan form reservasi -->
                <aside class="sb-card h-fit border border-stone-100 bg-white overflow-hidden lg:sticky lg:top-24">
                    <div class="h-1.5 bg-gradient-to-r from-emerald-400 via-emerald-600 to-teal-600"></div>
                    <div class="p-6">
                        <p class="text-[10px] font-black uppercase tracking-widest text-stone-400">Harga Paket</p>
                        <p class="sb-font-display mt-1 text-3xl font-semibold text-emerald-800">Rp
                            {{ number_format($tourPackage->price, 0, ',', '.') }}</p>
                        <p class="mt-1 text-[11px] text-stone-400">per orang</p>

                        <div
                            class="mt-5 flex items-center gap-2 rounded-2xl bg-emerald-50/60 border border-emerald-100 px-4 py-3">
                            <svg class="h-4.5 w-4.5 flex-shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                            <p class="text-xs font-bold text-stone-700">Durasi: {{ $tourPackage->duration }}</p>
                        </div>

                        <a href="{{ route('reservations.create', ['package' => $tourPackage->id]) }}"
                            class="mt-6 flex w-full items-center justify-center rounded-2xl bg-emerald-700 py-4 px-5 text-sm font-black uppercase tracking-wide text-white shadow-lg shadow-emerald-700/25 hover:bg-emerald-800 hover:shadow-emerald-700/35 active:scale-[0.98] transition-all duration-200">
                            Reservasi Paket
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </article>
</x-website-layout>