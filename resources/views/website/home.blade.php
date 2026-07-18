@php
    $heroImage = $settings['hero_image'] ? \Illuminate\Support\Facades\Storage::disk('public')->url($settings['hero_image']) : null;
@endphp

<x-website-layout :title="$settings['hero_title']">

    {{-- ============ HERO ============ --}}
    <section class="relative min-h-[620px] overflow-hidden bg-emerald-950 text-white">
        @if ($heroImage)
            <img src="{{ $heroImage }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-70">
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/90 via-emerald-950/55 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent"></div>

        <div class="relative mx-auto flex min-h-[620px] max-w-7xl flex-col justify-center px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm font-semibold uppercase tracking-wide text-emerald-200 ring-1 ring-inset ring-white/20">
                    Desa Wisata Kota Batu
                </p>
                <h1 class="mt-5 text-5xl font-bold leading-tight sm:text-6xl">{{ $settings['hero_title'] }}</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-emerald-50">{{ $settings['hero_subtitle'] }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('reservations.create') }}"
                       class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 font-semibold text-emerald-900 transition hover:bg-emerald-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-950">
                        Reservasi Wisata
                    </a>
                    <a href="{{ route('destinasi.index') }}"
                       class="inline-flex items-center gap-2 rounded-md border border-white/60 px-5 py-3 font-semibold text-white transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-950">
                        Lihat Destinasi
                    </a>
                </div>
            </div>

            {{-- Quick stats strip --}}
            @if ($featuredDestinations->count() || $tourPackages->count() || $products->count())
                <div class="mt-14 flex max-w-2xl flex-wrap gap-8 border-t border-white/15 pt-6">
                    @if ($featuredDestinations->count())
                        <div>
                            <p class="text-3xl font-bold">{{ $featuredDestinations->count() }}+</p>
                            <p class="mt-1 text-sm text-emerald-100">Destinasi Wisata</p>
                        </div>
                    @endif
                    @if ($tourPackages->count())
                        <div>
                            <p class="text-3xl font-bold">{{ $tourPackages->count() }}+</p>
                            <p class="mt-1 text-sm text-emerald-100">Paket Wisata</p>
                        </div>
                    @endif
                    @if ($products->count())
                        <div>
                            <p class="text-3xl font-bold">{{ $products->count() }}+</p>
                            <p class="mt-1 text-sm text-emerald-100">Produk UMKM</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- ============ TENTANG DESA ============ --}}
    <section class="py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8">
            <div>
                <x-section-heading eyebrow="Tentang Desa" title="Wisata berbasis alam, pertanian, dan masyarakat" />
                <p class="mt-6 leading-8 text-stone-700">{{ $settings['about'] }}</p>
            </div>
            @if ($settings['profile_video_url'])
                <div class="overflow-hidden rounded-lg border border-stone-200 shadow-sm">
                    <iframe class="aspect-video w-full" src="{{ $settings['profile_video_url'] }}" title="Video Profil" allowfullscreen></iframe>
                </div>
            @endif
        </div>
    </section>

    {{-- ============ DESTINASI UNGGULAN ============ --}}
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading title="Destinasi Unggulan" description="Pilihan tempat wisata utama di Desa Sumberbrantas." />
                <a href="{{ route('destinasi.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                    Lihat semua destinasi &rarr;
                </a>
            </div>

            @forelse ($featuredDestinations as $destination)
                @if ($loop->first)
                    <div class="mt-10 grid gap-6 md:grid-cols-3">
                @endif

                        <a href="{{ route('destinasi.show', $destination) }}"
                           class="group overflow-hidden rounded-lg border border-stone-200 bg-white transition hover:shadow-md">
                            <div class="h-52 w-full overflow-hidden">
                                <img src="{{ $destination->cover_image_url }}" alt="{{ $destination->name }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold group-hover:text-emerald-700">{{ $destination->name }}</h3>
                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-stone-600">{{ $destination->short_description }}</p>
                            </div>
                        </a>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="mt-10 rounded-lg border border-dashed border-stone-300 p-10 text-center text-stone-500">
                    Belum ada destinasi unggulan yang ditampilkan saat ini.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ============ PAKET WISATA ============ --}}
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading title="Paket Wisata" description="Paket terkurasi dengan pemandu lokal dan aktivitas desa." />
                <a href="{{ route('paket-wisata.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                    Lihat semua paket &rarr;
                </a>
            </div>

            @forelse ($tourPackages as $package)
                @if ($loop->first)
                    <div class="mt-10 grid gap-6 md:grid-cols-3">
                @endif

                        <a href="{{ route('paket-wisata.show', $package) }}"
                           class="group flex flex-col rounded-lg border border-stone-200 bg-white p-6 transition hover:shadow-md">
                            <span class="inline-flex w-fit items-center rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">
                                {{ $package->duration }}
                            </span>
                            <h3 class="mt-4 text-xl font-bold group-hover:text-emerald-700">{{ $package->name }}</h3>
                            <div class="mt-auto flex items-baseline gap-1 pt-6">
                                <span class="text-xs text-stone-500">mulai dari</span>
                                <span class="font-semibold text-stone-900">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            </div>
                        </a>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="mt-10 rounded-lg border border-dashed border-stone-300 p-10 text-center text-stone-500">
                    Paket wisata belum tersedia. Silakan hubungi kami untuk penawaran khusus.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ============ EVENT & PRODUK UMKM ============ --}}
    <section class="bg-white py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">

            {{-- Event --}}
            <div>
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-section-heading title="Event Terdekat" />
                    <a href="{{ route('event.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                        Lihat semua &rarr;
                    </a>
                </div>
                <div class="mt-8 grid gap-4">
                    @forelse ($upcomingEvents as $event)
                        <a href="{{ route('event.show', $event) }}"
                           class="group flex items-start gap-4 rounded-lg border border-stone-200 p-5 transition hover:border-emerald-200 hover:bg-emerald-50/50">
                            <div class="flex h-12 w-12 flex-none flex-col items-center justify-center rounded-md bg-emerald-100 text-emerald-800">
                                <span class="text-xs font-semibold uppercase leading-none">{{ $event->start_date->translatedFormat('M') }}</span>
                                <span class="text-lg font-bold leading-none">{{ $event->start_date->format('d') }}</span>
                            </div>
                            <div>
                                <p class="text-sm text-emerald-700">{{ $event->start_date->translatedFormat('d F Y H:i') }}</p>
                                <h3 class="mt-1 font-bold group-hover:text-emerald-700">{{ $event->title }}</h3>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-lg border border-dashed border-stone-300 p-8 text-center text-sm text-stone-500">
                            Belum ada event yang dijadwalkan dalam waktu dekat.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Produk UMKM --}}
            <div>
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-section-heading title="Produk UMKM" />
                    <a href="{{ route('produk.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                        Lihat semua &rarr;
                    </a>
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    @forelse ($products as $product)
                        <a href="{{ route('produk.show', $product) }}"
                           class="group overflow-hidden rounded-lg border border-stone-200 bg-white transition hover:shadow-md">
                            @if (isset($product->image_url))
                                <div class="h-32 w-full overflow-hidden">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-bold group-hover:text-emerald-700">{{ $product->name }}</h3>
                                <p class="mt-2 text-sm font-semibold text-emerald-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-2 rounded-lg border border-dashed border-stone-300 p-8 text-center text-sm text-stone-500">
                            Produk UMKM belum tersedia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ============ GALERI ============ --}}
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading title="Galeri" description="Cuplikan suasana wisata dan aktivitas masyarakat." />

            @forelse ($galleries as $gallery)
                @if ($loop->first)
                    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @endif

                        <div class="group relative h-56 w-full overflow-hidden rounded-lg">
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 transition group-hover:opacity-100">
                                <p class="p-4 text-sm font-semibold text-white">{{ $gallery->title }}</p>
                            </div>
                        </div>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="mt-10 rounded-lg border border-dashed border-stone-300 p-10 text-center text-stone-500">
                    Galeri foto akan segera hadir.
                </div>
            @endforelse
        </div>
    </section>

    {{-- ============ CTA RESERVASI ============ --}}
    <section class="relative overflow-hidden bg-emerald-800 py-14 text-white">
        <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-emerald-700/40 blur-3xl"></div>
        <div class="relative mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 sm:px-6 md:flex-row md:items-center lg:px-8">
            <div>
                <h2 class="text-3xl font-bold">Rencanakan kunjungan Anda ke Sumberbrantas</h2>
                <p class="mt-3 max-w-xl text-emerald-50">Kirim reservasi dan tim desa wisata akan membantu konfirmasi jadwal, pemandu, dan aktivitas selama kunjungan.</p>
            </div>
            <div class="flex flex-none flex-wrap gap-3">
                <a href="{{ route('reservations.create') }}"
                   class="inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 font-semibold text-emerald-900 transition hover:bg-emerald-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-800">
                    Reservasi Sekarang
                </a>
            </div>
        </div>
    </section>
</x-website-layout>