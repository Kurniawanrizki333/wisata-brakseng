<x-website-layout title="Destinasi Wisata">

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
            <x-section-heading title="Destinasi Wisata"
                description="Temukan tempat terbaik untuk menikmati alam Sumberbrantas." />

            @forelse ($destinations as $destination)
                @if ($loop->first)
                    <div class="mt-10 grid gap-6 md:grid-cols-3">
                @endif

                    <a href="{{ route('destinasi.show', $destination) }}"
                        class="sb-card group overflow-hidden border border-stone-100 bg-white block focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                        <div class="sb-img-zoom">
                            <img src="{{ $destination->cover_image_url }}" alt="{{ $destination->name }}" loading="lazy"
                                class="h-56 w-full object-cover">
                        </div>
                        <div class="p-5">
                            <h2
                                class="sb-font-display text-xl font-semibold text-emerald-950 group-hover:text-emerald-700 transition-colors">
                                {{ $destination->name }}</h2>
                            <p class="mt-2 line-clamp-3 text-sm leading-6 text-stone-500">
                                {{ $destination->short_description }}</p>
                            <p class="mt-4 inline-flex items-center gap-1 text-sm font-extrabold text-emerald-700">
                                Rp {{ number_format($destination->ticket_price, 0, ',', '.') }}
                                <span class="text-[10px] font-medium text-stone-400 normal-case">/ orang</span>
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
                                d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.498a1.125 1.125 0 00-1.006 0L3.622 5.935A1.125 1.125 0 003 6.94v10.936c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                        </svg>
                    </span>
                    <p class="sb-font-display text-lg font-semibold text-stone-700">Belum ada destinasi terdaftar</p>
                    <p class="text-sm text-stone-400">Destinasi wisata akan segera ditambahkan di sini.</p>
                </div>
            @endforelse

            @if ($destinations->hasPages())
                <div class="mt-10 sb-pagination">{{ $destinations->links() }}</div>
            @endif
        </div>
    </section>
</x-website-layout>