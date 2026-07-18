<x-website-layout title="Galeri">

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
            border-radius: 1.25rem;
            transition: box-shadow .25s ease, transform .25s ease;
            box-shadow: 0 1px 2px rgba(20, 83, 45, 0.05);
        }

        .sb-card:hover {
            box-shadow: 0 14px 30px -12px rgba(20, 83, 45, 0.18);
            transform: translateY(-3px);
        }

        .sb-img-zoom {
            overflow: hidden;
            border-radius: 1.25rem;
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

        #lightbox.is-open {
            display: flex;
        }

        #lightbox-image {
            opacity: 0;
            transition: opacity .25s ease;
        }

        #lightbox-image.is-loaded {
            opacity: 1;
        }
    </style>

    <section class="sb-font-body sb-hero-bg py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading title="Galeri"
                description="Dokumentasi destinasi, aktivitas wisata, dan suasana desa." />

            @forelse ($galleries as $gallery)
                @if ($loop->first)
                    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @endif

                    <button type="button"
                        class="sb-card group text-left bg-white border border-stone-100 overflow-hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                        data-lightbox="{{ $gallery->image_url }}" data-title="{{ $gallery->title }}">
                        <div class="sb-img-zoom">
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy"
                                class="h-56 w-full object-cover">
                        </div>
                        <p class="px-4 py-3 text-sm font-bold text-stone-800">{{ $gallery->title }}</p>
                    </button>

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
                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </span>
                    <p class="sb-font-display text-lg font-semibold text-stone-700">Belum ada dokumentasi</p>
                    <p class="text-sm text-stone-400">Galeri foto akan segera ditambahkan di sini.</p>
                </div>
            @endforelse

            @if ($galleries->hasPages())
                <div class="mt-10 sb-pagination">{{ $galleries->links() }}</div>
            @endif
        </div>
    </section>

    <!-- Lightbox: aksesibel (Escape, klik backdrop, role dialog) -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 p-4" role="dialog"
        aria-modal="true" aria-label="Pratinjau gambar galeri">
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
                lbImage.classList.remove('is-loaded');
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

            lbImage.addEventListener('load', () => lbImage.classList.add('is-loaded'));

            document.querySelectorAll('[data-lightbox]').forEach((button) => {
                button.addEventListener('click', () => openLightbox(button.dataset.lightbox, button.dataset.title));
            });

            closeBtn.addEventListener('click', closeLightbox);

            // Klik di area backdrop (luar gambar) untuk menutup
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            // Escape key untuk menutup
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
            });
        })();
    </script>
</x-website-layout>