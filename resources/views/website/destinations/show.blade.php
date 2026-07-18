<x-website-layout :title="$destination->name">

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

        .sb-img-zoom {
            overflow: hidden;
            border-radius: 1rem;
        }

        .sb-img-zoom img {
            transition: transform .4s ease;
        }

        .sb-img-zoom:hover img {
            transform: scale(1.07);
        }

        #lightbox.is-open {
            display: flex;
        }
    </style>

    <article class="sb-font-body py-10 bg-[#FAFAF5]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-1.5 text-xs font-semibold text-stone-400">
                <a href="{{ route('destinasi.index') }}" class="hover:text-emerald-700 transition-colors">Destinasi
                    Wisata</a>
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-stone-600 truncate max-w-[220px]">{{ $destination->name }}</span>
            </nav>

            <!-- Hero dengan overlay judul -->
            <div class="relative h-[420px] w-full overflow-hidden rounded-3xl">
                <img src="{{ $destination->cover_image_url }}" alt="{{ $destination->name }}"
                    class="h-full w-full object-cover">
                <div class="sb-hero-overlay absolute inset-0"></div>
                <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                    <h1 class="sb-font-display text-3xl sm:text-4xl font-semibold text-white leading-tight">
                        {{ $destination->name }}</h1>
                </div>
            </div>

            <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_360px]">
                <div>
                    <div class="whitespace-pre-line text-[15px] leading-8 text-stone-700">
                        {{ $destination->description }}</div>

                    @if ($destination->images->count())
                        <h2 class="sb-font-display mt-10 text-2xl font-semibold text-emerald-950">Galeri Foto</h2>
                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            @foreach ($destination->images as $image)
                                <button type="button"
                                    class="sb-img-zoom block w-full focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                                    data-lightbox="{{ $image->image_url }}"
                                    data-title="{{ $image->caption ?? $destination->name }}">
                                    <img src="{{ $image->image_url }}" alt="{{ $image->caption ?? $destination->name }}"
                                        loading="lazy" class="h-56 w-full rounded-2xl object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <aside class="sb-card h-fit border border-stone-100 bg-white p-6">
                    <dl class="grid gap-5 text-sm">
                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <dt class="text-[10px] font-black uppercase tracking-widest text-stone-400">Harga Tiket
                                </dt>
                                <dd class="mt-1 font-extrabold text-emerald-800">Rp
                                    {{ number_format($destination->ticket_price, 0, ',', '.') }}</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                </svg>
                            </span>
                            <div>
                                <dt class="text-[10px] font-black uppercase tracking-widest text-stone-400">Jam
                                    Operasional</dt>
                                <dd class="mt-1 font-bold text-stone-800">{{ $destination->operating_hours }}</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </span>
                            <div>
                                <dt class="text-[10px] font-black uppercase tracking-widest text-stone-400">Alamat</dt>
                                <dd class="mt-1 font-bold text-stone-800 leading-relaxed">{{ $destination->address }}
                                </dd>
                            </div>
                        </div>
                    </dl>

                    @if ($destination->latitude && $destination->longitude)
                        <iframe class="mt-6 aspect-video w-full rounded-2xl border border-stone-100"
                            title="Peta lokasi {{ $destination->name }}"
                            src="https://www.google.com/maps?q={{ $destination->latitude }},{{ $destination->longitude }}&output=embed"
                            loading="lazy"></iframe>
                    @endif
                </aside>
            </div>
        </div>
    </article>

    @if ($destination->images->count())
        <!-- Lightbox galeri foto destinasi (konsisten dengan halaman Galeri) -->
        <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 p-4" role="dialog"
            aria-modal="true" aria-label="Pratinjau foto destinasi">
            <button type="button" id="lightbox-close" aria-label="Tutup pratinjau"
                class="absolute right-4 top-4 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-stone-900 shadow-lg hover:bg-stone-100 transition">
                Tutup
            </button>
            <figure class="max-w-5xl w-full">
                <img id="lightbox-image" src="" alt="" class="max-h-[80vh] w-full rounded-2xl object-contain">
                <figcaption id="lightbox-title" class="mt-3 text-center text-white sb-font-body font-semibold"></figcaption>
            </figure>
        </div>

        <script>
            (function () {
                const lightbox = document.getElementById('lightbox');
                const lbImage = document.getElementById('lightbox-image');
                const lbTitle = document.getElementById('lightbox-title');
                const closeBtn = document.getElementById('lightbox-close');
                let lastFocusedEl = null;

                function openLightbox(src, title) {
                    lastFocusedEl = document.activeElement;
                    lbImage.src = src;
                    lbImage.alt = title || '';
                    lbTitle.textContent = title || '';
                    lightbox.classList.remove('hidden');
                    lightbox.classList.add('is-open');
                    closeBtn.focus();
                    document.body.style.overflow = 'hidden';
                }
                function closeLightbox() {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('is-open');
                    document.body.style.overflow = '';
                    if (lastFocusedEl) lastFocusedEl.focus();
                }

                document.querySelectorAll('[data-lightbox]').forEach((button) => {
                    button.addEventListener('click', () => openLightbox(button.dataset.lightbox, button.dataset.title));
                });
                closeBtn.addEventListener('click', closeLightbox);
                lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeLightbox(); });
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
                });
            })();
        </script>
    @endif
</x-website-layout>