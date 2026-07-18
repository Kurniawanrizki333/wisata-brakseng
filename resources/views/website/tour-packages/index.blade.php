<x-website-layout title="Paket Wisata">

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
            <x-section-heading title="Paket Wisata" description="Pilih paket wisata sesuai kebutuhan kunjungan Anda." />

            @forelse ($tourPackages as $package)
                @if ($loop->first)
                    <div class="mt-10 grid gap-6 md:grid-cols-3">
                @endif

                    <a href="{{ route('paket-wisata.show', $package) }}"
                        class="sb-card group overflow-hidden border border-stone-100 bg-white block focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                        <div class="sb-img-zoom relative">
                            <img src="{{ $package->cover_image_url }}" alt="{{ $package->name }}" loading="lazy"
                                class="h-52 w-full object-cover">
                            <span
                                class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-emerald-700 shadow-sm">
                                {{ $package->duration }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h2
                                class="sb-font-display text-xl font-semibold text-emerald-950 group-hover:text-emerald-700 transition-colors">
                                {{ $package->name }}</h2>
                            @if ($package->facility)
                                <p class="mt-2 text-[11px] text-stone-400 truncate">
                                    {{ Str::of($package->facility)->replace("\n", " · ")->trim()->limit(60) }}
                                </p>
                            @endif
                            <p class="mt-4 font-extrabold text-emerald-700">Rp
                                {{ number_format($package->price, 0, ',', '.') }}</p>
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
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </span>
                    <p class="sb-font-display text-lg font-semibold text-stone-700">Belum ada paket tersedia</p>
                    <p class="text-sm text-stone-400">Paket wisata akan segera ditambahkan di sini.</p>
                </div>
            @endforelse

            @if ($tourPackages->hasPages())
                <div class="mt-10 sb-pagination">{{ $tourPackages->links() }}</div>
            @endif
        </div>
    </section>
</x-website-layout>