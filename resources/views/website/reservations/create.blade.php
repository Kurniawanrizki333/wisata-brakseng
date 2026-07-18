<x-website-layout title="Reservasi Wisata - Desa Wisata Sumberbrantas">

    @php
        // Sumber tunggal untuk info rekening — hindari duplikasi hardcoded di 2 tempat
        $bankName = 'Bank Mandiri';
        $bankAccountNumber = '144-00-1928374-1';
        $bankAccountHolder = 'a.n. Desa Wisata Sumberbrantas';
    @endphp

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
                radial-gradient(60% 80% at 12% 0%, rgba(34, 139, 74, 0.12) 0%, rgba(34, 139, 74, 0) 60%),
                radial-gradient(50% 60% at 100% 10%, rgba(201, 169, 89, 0.10) 0%, rgba(201, 169, 89, 0) 60%),
                #FAFAF5;
        }

        /* Trail connector between steps */
        .sb-trail {
            position: relative;
        }

        .sb-trail::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 34px;
            bottom: -6px;
            width: 2px;
            background-image: linear-gradient(#166534 60%, rgba(0, 0, 0, 0) 0%);
            background-position: left;
            background-size: 2px 8px;
            background-repeat: repeat-y;
        }

        .sb-trail:last-child::before {
            display: none;
        }

        .sb-marker {
            box-shadow: 0 0 0 4px #FAFAF5;
        }

        /* Konsistensi tinted-shadow untuk semua card interaktif */
        .package-card,
        .payment-card {
            box-shadow: 0 1px 2px rgba(20, 83, 45, 0.04);
        }

        .package-card:hover,
        .payment-card:hover {
            box-shadow: 0 8px 20px -6px rgba(20, 83, 45, 0.12);
        }

        .package-card.is-selected {
            background: linear-gradient(0deg, rgba(240, 253, 244, 0.7), rgba(240, 253, 244, 0.7)), #ffffff;
            box-shadow: 0 8px 20px -6px rgba(20, 83, 45, 0.14);
        }

        .payment-card.is-selected {
            box-shadow: 0 8px 20px -6px rgba(20, 83, 45, 0.14);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(38%) sepia(63%) saturate(468%) hue-rotate(93deg) brightness(93%) contrast(92%);
        }

        ::selection {
            background: #bbf7d0;
            color: #14532d;
        }

        /* Submit button loading state */
        button[data-loading="true"] .btn-label {
            visibility: hidden;
        }

        button[data-loading="true"] .btn-spinner {
            display: inline-flex;
        }

        .btn-spinner {
            display: none;
            border: 2.5px solid rgba(255, 255, 255, 0.35);
            border-top-color: #fff;
            border-radius: 9999px;
            width: 18px;
            height: 18px;
            animation: sb-spin 0.7s linear infinite;
        }

        @keyframes sb-spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Focus ring untuk card yang dinavigasi via keyboard (a11y) */
        .package-card:focus-visible,
        .payment-card:focus-visible {
            outline: 2px solid #059669;
            outline-offset: 2px;
        }
    </style>

    <section class="sb-font-body sb-hero-bg min-h-screen py-10 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
                <span
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-white text-emerald-800 border border-emerald-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                    </span>
                    Sistem Reservasi Online
                </span>
                <h1
                    class="sb-font-display mt-4 text-3xl sm:text-4xl lg:text-[2.75rem] font-semibold text-emerald-950 tracking-tight leading-tight">
                    Rencanakan Kunjungan Anda
                    <span class="block text-emerald-600">ke Sumberbrantas</span>
                </h1>
                <p class="mt-3 text-sm text-stone-500 leading-relaxed">
                    Amankan tiket masuk, paket wisata, dan pemandu lokal dalam satu langkah mudah.
                </p>
            </div>

            @if (session('success'))
                <!-- Success Banner (lebih "celebratory": icon lebih besar, aksen lebih kuat) -->
                <div
                    class="mb-8 rounded-3xl border border-emerald-200 bg-white shadow-xl shadow-emerald-900/10 relative overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-emerald-400 via-emerald-600 to-teal-600 w-full"></div>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start gap-4">
                            <span
                                class="relative flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/30">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-2xl bg-emerald-400 opacity-40"></span>
                                <svg class="relative h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="sb-font-display text-xl font-semibold text-emerald-950">Reservasi Diterima!</h3>
                                <p class="text-xs text-stone-500 mt-1">{!! session('success') !!}</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100">
                                <p class="text-[10px] text-emerald-700/70 font-bold uppercase tracking-wider">Kode Pemesanan
                                </p>
                                <p class="text-xl font-black text-emerald-950 mt-1">{{ session('reservation_code') }}</p>
                            </div>
                            <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100">
                                <p class="text-[10px] text-emerald-700/70 font-bold uppercase tracking-wider">Nomor Invoice
                                </p>
                                <p class="text-xl font-black text-emerald-950 mt-1">{{ session('nomor_invoice') }}</p>
                            </div>
                            <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100">
                                <p class="text-[10px] text-emerald-700/70 font-bold uppercase tracking-wider">Total Tagihan
                                </p>
                                <p class="text-xl font-black text-emerald-700 mt-1">Rp
                                    {{ number_format(session('total_price'), 0, ',', '.') }}</p>
                            </div>
                            <div
                                class="col-span-2 sm:col-span-3 bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100">
                                <p class="text-[10px] text-emerald-700/70 font-bold uppercase tracking-wider">Metode Bayar
                                </p>
                                <p class="text-xs font-extrabold text-emerald-950 mt-1">
                                    @if(session('payment_method') === 'bank_transfer') Transfer Bank
                                    @elseif(session('payment_method') === 'qris') QRIS (Digital)
                                    @else Bayar di Loket @endif
                                </p>
                            </div>
                        </div>

                        <div
                            class="mt-5 rounded-2xl bg-stone-50 border border-stone-100 p-5 text-xs text-stone-600 leading-relaxed">
                            @if(session('payment_url'))
                                <a href="{{ session('payment_url') }}"
                                    class="mb-4 inline-flex rounded-xl bg-emerald-700 px-4 py-2.5 text-[10px] font-black uppercase tracking-wider text-white shadow-sm hover:bg-emerald-800">
                                    Bayar Sekarang
                                </a>
                            @endif
                            @if(session('payment_method') === 'bank_transfer')
                                <p class="font-bold text-stone-800 text-[10px] uppercase tracking-wider mb-2.5">Panduan
                                    Transfer:</p>
                                <div
                                    class="inline-flex flex-col bg-white border border-stone-200 rounded-xl px-4 py-3 mb-2 shadow-sm">
                                    <span
                                        class="text-[8px] uppercase font-black text-stone-400 tracking-wider">{{ $bankName }}</span>
                                    <span class="font-black text-emerald-800 text-sm mt-0.5">{{ $bankAccountNumber }}</span>
                                    <span class="text-[9px] font-semibold text-stone-500">{{ $bankAccountHolder }}</span>
                                </div>
                                <p class="text-[9px] text-stone-500 italic">*Unggah bukti pembayaran melalui link pembayaran
                                    yang dikirim ke email Anda.</p>
                            @elseif(session('payment_method') === 'qris')
                                <p class="font-bold text-stone-800 text-[10px] uppercase tracking-wider mb-1">Panduan QRIS:</p>
                                <p>Instruksi QRIS tersedia di halaman pembayaran yang dikirim ke email Anda.</p>
                            @else
                                <p class="font-bold text-stone-800 text-[10px] uppercase tracking-wider mb-1">Panduan Bayar di
                                    Tempat:</p>
                                <p>Tunjukkan Kode Pemesanan <strong>{{ session('reservation_code') }}</strong> kepada petugas
                                    loket saat tiba di gerbang masuk wisata.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Form Grid -->
            <form method="POST" action="{{ route('reservations.store') }}" id="reservationForm"
                class="grid gap-6 lg:grid-cols-[1fr_340px] items-start" novalidate>
                @csrf

                <!-- LEFT: Form Steps -->
                <div class="space-y-4">
                    <div
                        class="bg-white border border-stone-100 rounded-3xl shadow-sm shadow-emerald-900/5 overflow-hidden">

                        <!-- SECTION 1: Pilih Paket -->
                        <div class="p-5 sm:p-7 sb-trail">
                            <div class="flex items-center gap-3 mb-5 relative z-10">
                                <span
                                    class="sb-marker flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white font-black text-xs">1</span>
                                <div>
                                    <h3 class="sb-font-display text-base font-semibold text-emerald-950">Pilih Paket
                                        Kunjungan</h3>
                                    <p class="text-[11px] text-stone-400">Sesuaikan dengan rencana perjalanan Anda</p>
                                </div>
                            </div>

                            <div class="pl-0 sm:pl-11 space-y-2.5" role="radiogroup" aria-label="Pilih paket kunjungan"
                                id="package_radiogroup">

                                <!-- Package cards -->
                                @forelse ($tourPackages as $package)
                                    <div class="package-card flex flex-wrap sm:flex-nowrap items-start sm:items-center gap-3 p-3.5 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer transition-all duration-150 hover:border-emerald-400 select-none"
                                        role="radio" tabindex="0" aria-checked="false" data-id="{{ $package->id }}"
                                        data-price="{{ $package->price }}" data-name="{{ $package->name }}">
                                        <!-- Radio dot -->
                                        <div
                                            class="radio-indicator flex-shrink-0 h-5 w-5 rounded-full border-2 border-stone-300 bg-white flex items-center justify-center transition-all mt-0.5 sm:mt-0">
                                            <div class="radio-dot h-2 w-2 rounded-full bg-white"></div>
                                        </div>
                                        <!-- Thumb -->
                                        <div
                                            class="flex-shrink-0 h-12 w-12 sm:h-14 sm:w-14 rounded-xl overflow-hidden border border-stone-200">
                                            @if($package->cover_image_url)
                                                <img src="{{ $package->cover_image_url }}" alt="{{ $package->name }}"
                                                    loading="lazy" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full bg-emerald-50 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-emerald-300" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Text: min-w-0 wajib supaya truncate jalan, flex-1 biar ambil sisa ruang -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <p
                                                    class="text-sm font-bold text-stone-900 leading-tight truncate max-w-full">
                                                    {{ $package->name }}</p>
                                                <span
                                                    class="px-1.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-100 leading-none whitespace-nowrap flex-shrink-0">{{ $package->duration }}</span>
                                            </div>
                                            @if($package->facility)
                                                <p class="text-[11px] text-stone-400 mt-1.5 leading-none truncate">
                                                    {{ str_replace("\n", " · ", trim($package->facility)) }}
                                                </p>
                                            @endif
                                        </div>
                                        <!-- Price: turun ke baris baru di mobile (basis-full), align kanan mengikuti lebar radio+thumb+gap -->
                                        <div
                                            class="flex-shrink-0 text-right basis-full sm:basis-auto pl-[3.75rem] sm:pl-0 -mt-1 sm:mt-0">
                                            <span class="text-sm font-extrabold text-emerald-700">Rp
                                                {{ number_format($package->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Empty state: belum ada paket tersedia -->
                                    <div
                                        class="flex flex-col items-center text-center gap-2 py-8 px-4 rounded-2xl border-2 border-dashed border-stone-200 bg-stone-50/50">
                                        <span
                                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white border border-stone-200 text-stone-300">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                            </svg>
                                        </span>
                                        <p class="text-xs font-bold text-stone-500">Belum ada paket wisata tersedia</p>
                                        <p class="text-[11px] text-stone-400">Anda tetap bisa reservasi tanpa paket khusus
                                            di atas.</p>
                                    </div>
                                @endforelse
                            </div>

                            <input type="hidden" name="tour_package_id" id="selected_package_id"
                                value="{{ old('tour_package_id', $selectedPackage) }}">
                            @error('tour_package_id') <p class="text-xs text-red-600 mt-2 pl-0 sm:pl-11">{{ $message }}
                            </p> @enderror
                        </div>

                        <!-- SECTION 2: Data Diri -->
                        <div class="p-5 sm:p-7 sb-trail border-t border-stone-100">
                            <div class="flex items-center gap-3 mb-5 relative z-10">
                                <span
                                    class="sb-marker flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white font-black text-xs">2</span>
                                <div>
                                    <h3 class="sb-font-display text-base font-semibold text-emerald-950">Data Pengunjung
                                        & Tanggal</h3>
                                    <p class="text-[11px] text-stone-400">Pastikan data dapat dihubungi dengan mudah</p>
                                </div>
                            </div>

                            <div class="pl-0 sm:pl-11 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div class="grid gap-1.5">
                                    <label for="visitor_name"
                                        class="text-[9px] font-bold text-stone-500 uppercase tracking-widest">Nama
                                        Lengkap</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-500">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </span>
                                        <input id="visitor_name" name="visitor_name" value="{{ old('visitor_name') }}"
                                            class="pl-9 w-full bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-xs py-2.5 px-3 transition outline-none"
                                            placeholder="Budi Santoso" required aria-describedby="err_visitor_name">
                                    </div>
                                    <p id="err_visitor_name" class="text-[10px] text-red-600 min-h-[14px]">
                                        @error('visitor_name') {{ $message }} @enderror</p>
                                </div>

                                <div class="grid gap-1.5">
                                    <label for="email"
                                        class="text-[9px] font-bold text-stone-500 uppercase tracking-widest">Email</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-500">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                            </svg>
                                        </span>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="pl-9 w-full bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-xs py-2.5 px-3 transition outline-none"
                                            placeholder="budi@gmail.com" required aria-describedby="err_email">
                                    </div>
                                    <p id="err_email" class="text-[10px] text-red-600 min-h-[14px]">@error('email')
                                    {{ $message }} @enderror</p>
                                </div>

                                <div class="grid gap-1.5">
                                    <label for="phone"
                                        class="text-[9px] font-bold text-stone-500 uppercase tracking-widest">Nomor
                                        Telepon / WhatsApp</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-500">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.302a12.01 12.01 0 01-4.82-4.82c-.24-.44-.074-.927.301-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                            </svg>
                                        </span>
                                        <input type="tel" inputmode="numeric" id="phone" name="phone"
                                            value="{{ old('phone') }}"
                                            class="pl-9 w-full bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-xs py-2.5 px-3 transition outline-none"
                                            placeholder="081234567890" pattern="^(0|\+62)8[0-9]{8,12}$" required
                                            aria-describedby="err_phone">
                                    </div>
                                    <p id="err_phone" class="text-[10px] text-red-600 min-h-[14px]">@error('phone')
                                    {{ $message }} @enderror</p>
                                </div>

                                <div class="grid gap-1.5">
                                    <label for="reservation_date_input"
                                        class="text-[9px] font-bold text-stone-500 uppercase tracking-widest">Tanggal
                                        Kunjungan</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-500">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                        </span>
                                        <input type="date" name="reservation_date" id="reservation_date_input"
                                            value="{{ old('reservation_date') }}" min="{{ now()->toDateString() }}"
                                            class="pl-9 w-full bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-xs py-2.5 px-3 transition outline-none"
                                            required aria-describedby="err_date">
                                    </div>
                                    <p id="err_date" class="text-[10px] text-red-600 min-h-[14px]">
                                        @error('reservation_date') {{ $message }} @enderror</p>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Metode Pembayaran -->
                        <div class="p-5 sm:p-7 border-t border-stone-100">
                            <div class="flex items-center gap-3 mb-5">
                                <span
                                    class="sb-marker flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white font-black text-xs">3</span>
                                <div>
                                    <h3 class="sb-font-display text-base font-semibold text-emerald-950">Metode
                                        Pembayaran</h3>
                                    <p class="text-[11px] text-stone-400">Pilih cara pembayaran yang paling mudah</p>
                                </div>
                            </div>

                            <div class="pl-0 sm:pl-11 grid grid-cols-3 gap-2 sm:gap-2.5" role="radiogroup"
                                aria-label="Pilih metode pembayaran">
                                <div class="payment-card cursor-pointer border-2 border-stone-200 rounded-2xl p-2.5 sm:p-3.5 flex flex-col items-center gap-2 transition-all duration-150 hover:border-emerald-400 bg-white"
                                    role="radio" tabindex="0" aria-checked="false" data-method="bank_transfer">
                                    <span
                                        class="pay-icon-wrap flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 transition-colors">
                                        <svg class="h-4.5 w-4.5 text-stone-400 flex-shrink-0 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                    </span>
                                    <span
                                        class="text-[10px] font-extrabold text-stone-700 text-center leading-tight">Transfer
                                        Bank</span>
                                    <span class="text-[8px] text-stone-400 text-center leading-none">Manual</span>
                                </div>

                                <div class="payment-card cursor-pointer border-2 border-stone-200 rounded-2xl p-2.5 sm:p-3.5 flex flex-col items-center gap-2 transition-all duration-150 hover:border-emerald-400 bg-white"
                                    role="radio" tabindex="0" aria-checked="false" data-method="qris">
                                    <span
                                        class="pay-icon-wrap flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 transition-colors">
                                        <svg class="h-4.5 w-4.5 text-stone-400 flex-shrink-0 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                        </svg>
                                    </span>
                                    <span
                                        class="text-[10px] font-extrabold text-stone-700 text-center leading-tight">QRIS</span>
                                    <span class="text-[8px] text-stone-400 text-center leading-none">E-Wallet</span>
                                </div>

                                <div class="payment-card cursor-pointer border-2 border-stone-200 rounded-2xl p-2.5 sm:p-3.5 flex flex-col items-center gap-2 transition-all duration-150 hover:border-emerald-400 bg-white"
                                    role="radio" tabindex="0" aria-checked="false" data-method="cash">
                                    <span
                                        class="pay-icon-wrap flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 transition-colors">
                                        <svg class="h-4.5 w-4.5 text-stone-400 flex-shrink-0 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5M5.25 7.5h13.5m-12 3h10.5m-9 3h7.5m-6 3h4.5" />
                                        </svg>
                                    </span>
                                    <span
                                        class="text-[10px] font-extrabold text-stone-700 text-center leading-tight">Tunai</span>
                                    <span class="text-[8px] text-stone-400 text-center leading-none">Di Loket</span>
                                </div>
                            </div>

                            <input type="hidden" name="payment_method" id="selected_payment_method"
                                value="{{ old('payment_method', 'bank_transfer') }}">

                            <!-- Instruction panels -->
                            <div class="mt-3.5 pl-0 sm:pl-11">
                                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 text-xs">
                                    <div id="panel_bank_transfer" class="payment-panel hidden">
                                        <p class="font-bold text-emerald-900 text-[10px] uppercase tracking-wider mb-2">
                                            Detail Transfer {{ $bankName }}</p>
                                        <div
                                            class="inline-block rounded-xl bg-white border border-stone-200 px-4 py-3 mb-2 shadow-sm">
                                            <span
                                                class="text-[8px] uppercase font-black text-stone-400 tracking-wider block">{{ $bankName }}</span>
                                            <span
                                                class="font-black text-emerald-800 text-sm block mt-0.5">{{ $bankAccountNumber }}</span>
                                            <span
                                                class="text-[9px] font-semibold text-stone-600">{{ $bankAccountHolder }}</span>
                                        </div>
                                        <p class="text-[10px] text-stone-500 leading-relaxed">Setelah checkout, invoice
                                            dan link pembayaran akan dikirim ke email Anda. Unggah bukti transfer
                                            melalui link tersebut.</p>
                                    </div>
                                    <div id="panel_qris" class="payment-panel hidden">
                                        <p class="font-bold text-emerald-900 text-[10px] uppercase tracking-wider mb-2">
                                            QRIS Digital</p>
                                        <p class="text-stone-500 leading-relaxed">Setelah checkout, invoice dan link
                                            pembayaran akan dikirim ke email Anda untuk mengunggah bukti pembayaran.</p>
                                    </div>
                                    <div id="panel_cash" class="payment-panel hidden">
                                        <p class="font-bold text-emerald-900 text-[10px] uppercase tracking-wider mb-2">
                                            Bayar di Loket</p>
                                        <p class="text-stone-500 leading-relaxed">Invoice tetap dikirim ke email Anda.
                                            Tunjukkan kode pemesanan kepada petugas saat kedatangan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT: Sticky Summary -->
                <div class="lg:sticky lg:top-24 space-y-4">

                    <!-- Summary Card -->
                    <div
                        class="bg-white border border-stone-100 rounded-3xl shadow-sm shadow-emerald-900/5 overflow-hidden">
                        <div class="h-1.5 bg-gradient-to-r from-emerald-400 via-emerald-600 to-teal-600"></div>
                        <div class="p-5 sm:p-6">
                            <h4 class="sb-font-display text-sm font-semibold text-emerald-950 mb-5">Ringkasan Pemesanan
                            </h4>

                            <div class="space-y-3.5 text-xs">
                                <div class="flex justify-between gap-4">
                                    <span class="text-stone-400 font-medium flex-shrink-0">Tanggal</span>
                                    <span id="summary_date"
                                        class="font-bold text-stone-800 text-right leading-tight">-</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="text-stone-400 font-medium flex-shrink-0">Paket</span>
                                    <span id="summary_package_name"
                                        class="font-bold text-stone-800 text-right leading-tight">-</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="text-stone-400 font-medium flex-shrink-0">Harga/Orang</span>
                                    <span id="display_price_per_person" class="font-bold text-stone-800">Rp 0</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="text-stone-400 font-medium flex-shrink-0">Metode Bayar</span>
                                    <span id="summary_payment_method"
                                        class="font-bold text-stone-800 text-right">Transfer Bank</span>
                                </div>

                                <div class="border-t border-dashed border-stone-200 pt-3.5">
                                    <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mb-2.5">
                                        Jumlah Peserta</p>
                                    <div class="flex items-center gap-2">
                                        <button type="button" id="btn_minus" aria-label="Kurangi jumlah peserta"
                                            class="h-8 w-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center font-bold text-emerald-700 hover:bg-emerald-100 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 select-none text-sm">−</button>
                                        <input type="number" min="1" max="500" inputmode="numeric" name="total_people"
                                            id="total_people" value="{{ old('total_people', 1) }}"
                                            aria-label="Jumlah peserta"
                                            class="w-14 text-center font-black rounded-xl border border-stone-200 py-1.5 text-xs focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 bg-stone-50 transition">
                                        <button type="button" id="btn_plus" aria-label="Tambah jumlah peserta"
                                            class="h-8 w-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center font-bold text-emerald-700 hover:bg-emerald-100 active:scale-95 transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 select-none text-sm">+</button>
                                        <span class="text-[10px] text-stone-400 font-medium ml-1">orang</span>
                                    </div>
                                    <p id="err_total_people" class="text-[10px] text-red-600 min-h-[14px] mt-1">
                                        @error('total_people') {{ $message }} @enderror</p>
                                </div>

                                <div>
                                    <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mb-2">
                                        Catatan (Opsional)</p>
                                    <textarea name="notes" rows="2"
                                        class="w-full rounded-xl border border-stone-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-xs py-2.5 px-3 text-stone-700 placeholder-stone-400 bg-stone-50 resize-none outline-none transition"
                                        placeholder="Contoh: 1 bus, minta pemandu wanita...">{{ old('notes') }}</textarea>
                                </div>

                                <div
                                    class="border-t border-dashed border-stone-200 pt-3.5 flex items-center justify-between">
                                    <span
                                        class="text-xs font-extrabold text-stone-800 uppercase tracking-wider">Total</span>
                                    <span id="display_total_price"
                                        class="sb-font-display text-2xl font-semibold text-emerald-700">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" id="submitBtn"
                        class="w-full rounded-2xl bg-emerald-700 py-4 px-5 text-sm font-black text-white shadow-lg shadow-emerald-700/25 hover:bg-emerald-800 hover:shadow-emerald-700/35 active:scale-[0.98] transition-all duration-200 tracking-wide uppercase focus:outline-none focus:ring-4 focus:ring-emerald-500/30 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span class="btn-label">Checkout Sekarang</span>
                        <span class="btn-spinner" aria-hidden="true"></span>
                    </button>
                    <p class="text-[9px] text-stone-400 text-center leading-relaxed px-2">
                        Dengan mengklik tombol, Anda menyetujui seluruh ketentuan kunjungan wisata.
                    </p>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pCards = document.querySelectorAll('.package-card');
            const pInput = document.getElementById('selected_package_id');
            const totalPeopleInput = document.getElementById('total_people');
            const dateInput = document.getElementById('reservation_date_input');
            const payCards = document.querySelectorAll('.payment-card');
            const payInput = document.getElementById('selected_payment_method');
            const payPanels = document.querySelectorAll('.payment-panel');
            const form = document.getElementById('reservationForm');
            const submitBtn = document.getElementById('submitBtn');

            const elSummaryPkg = document.getElementById('summary_package_name');
            const elPricePerPerson = document.getElementById('display_price_per_person');
            const elTotalPrice = document.getElementById('display_total_price');
            const elSummaryDate = document.getElementById('summary_date');
            const elPayMethod = document.getElementById('summary_payment_method');
            const elErrTotalPeople = document.getElementById('err_total_people');

            function formatRp(val) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
            }

            function updateEstimation() {
                const sel = document.querySelector('.package-card.is-selected');
                if (!sel) return;
                const price = parseFloat(sel.dataset.price || 0);
                const people = clampPeople(totalPeopleInput.value);
                elSummaryPkg.textContent = sel.dataset.name;
                elPricePerPerson.textContent = formatRp(price);
                elTotalPrice.textContent = formatRp(price * people);

                const dv = dateInput.value;
                if (dv) {
                    const d = new Date(dv);
                    elSummaryDate.textContent = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                } else {
                    elSummaryDate.textContent = '-';
                }
            }

            // Jaga nilai jumlah peserta tetap dalam rentang 1-500 walau diketik manual
            function clampPeople(raw) {
                let v = parseInt(raw, 10);
                if (isNaN(v) || v < 1) v = 1;
                if (v > 500) v = 500;
                return v;
            }

            dateInput.addEventListener('change', updateEstimation);

            // Update saat user mengetik manual, bukan hanya lewat tombol +/-
            totalPeopleInput.addEventListener('input', updateEstimation);
            totalPeopleInput.addEventListener('blur', function () {
                const clamped = clampPeople(this.value);
                if (String(clamped) !== this.value) {
                    this.value = clamped;
                    elErrTotalPeople.textContent = '';
                    updateEstimation();
                }
            });

            document.getElementById('btn_plus').addEventListener('click', () => {
                const v = clampPeople(totalPeopleInput.value);
                if (v < 500) { totalPeopleInput.value = v + 1; updateEstimation(); }
            });
            document.getElementById('btn_minus').addEventListener('click', () => {
                const v = clampPeople(totalPeopleInput.value);
                if (v > 1) { totalPeopleInput.value = v - 1; updateEstimation(); }
            });

            // Helper: pilih satu card dalam grup radio kustom
            function selectCard(card, allCards, hiddenInput, valueAttr) {
                allCards.forEach(c => {
                    c.classList.remove('is-selected', 'border-emerald-500');
                    c.classList.add('border-stone-200');
                    c.setAttribute('aria-checked', 'false');
                    const ri = c.querySelector('.radio-indicator');
                    const rd = c.querySelector('.radio-dot');
                    if (ri) ri.className = 'radio-indicator flex-shrink-0 h-5 w-5 rounded-full border-2 border-stone-300 bg-white flex items-center justify-center transition-all';
                    if (rd) rd.className = 'radio-dot h-2 w-2 rounded-full bg-white';
                    const wrap = c.querySelector('.pay-icon-wrap');
                    const svg = c.querySelector('svg');
                    if (wrap) wrap.className = 'pay-icon-wrap flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 transition-colors';
                    if (svg) svg.className = 'h-4.5 w-4.5 text-stone-400 flex-shrink-0 transition-colors';
                });
                card.classList.add('is-selected', 'border-emerald-500');
                card.classList.remove('border-stone-200');
                card.setAttribute('aria-checked', 'true');
                if (hiddenInput) hiddenInput.value = card.dataset[valueAttr] || '';
            }

            // Package selection (klik + keyboard Enter/Space untuk aksesibilitas)
            pCards.forEach(card => {
                card.addEventListener('click', function () {
                    selectCard(this, pCards, pInput, 'id');
                    const ri = this.querySelector('.radio-indicator');
                    const rd = this.querySelector('.radio-dot');
                    if (ri) ri.className = 'radio-indicator flex-shrink-0 h-5 w-5 rounded-full border-2 border-emerald-600 bg-emerald-600 flex items-center justify-center transition-all';
                    if (rd) rd.className = 'radio-dot h-2 w-2 rounded-full bg-white';
                    updateEstimation();
                });
                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Payment selection (klik + keyboard)
            payCards.forEach(card => {
                card.addEventListener('click', function () {
                    selectCard(this, payCards, payInput, 'method');
                    const wrap = this.querySelector('.pay-icon-wrap');
                    const svg = this.querySelector('svg');
                    if (wrap) wrap.className = 'pay-icon-wrap flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 transition-colors';
                    if (svg) svg.className = 'h-4.5 w-4.5 text-emerald-700 flex-shrink-0 transition-colors';

                    const method = this.dataset.method;
                    payPanels.forEach(p => p.classList.add('hidden'));
                    const ap = document.getElementById('panel_' + method);
                    if (ap) ap.classList.remove('hidden');

                    const labels = { bank_transfer: 'Transfer Bank', qris: 'QRIS', cash: 'Bayar di Tempat' };
                    elPayMethod.textContent = labels[method] || method;
                });
                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Init selections
            const initPkg = pInput.value;
            const initCard = Array.from(pCards).find(c => c.dataset.id === initPkg) || pCards[0];
            if (initCard) initCard.click();

            const initPay = payInput.value || 'bank_transfer';
            const initPayCard = Array.from(payCards).find(c => c.dataset.method === initPay);
            if (initPayCard) initPayCard.click();

            updateEstimation();

            // Validasi ringan sebelum submit + cegah klik ganda
            form.addEventListener('submit', function (e) {
                let firstInvalid = null;

                // Validasi native (required, pattern, type=email, min tanggal, dll)
                if (!form.checkValidity()) {
                    e.preventDefault();
                    firstInvalid = form.querySelector(':invalid');
                }

                // Validasi tambahan jumlah peserta
                const people = clampPeople(totalPeopleInput.value);
                if (people < 1 || people > 500) {
                    e.preventDefault();
                    elErrTotalPeople.textContent = 'Jumlah peserta harus antara 1 dan 500.';
                    if (!firstInvalid) firstInvalid = totalPeopleInput;
                } else {
                    elErrTotalPeople.textContent = '';
                    totalPeopleInput.value = people;
                }

                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus({ preventScroll: true });
                    return;
                }

                // Lolos validasi: kunci tombol supaya tidak submit dobel
                submitBtn.disabled = true;
                submitBtn.dataset.loading = 'true';
            });
        });

        /** 
         * 
         *    <!-- Tanpa Paket -->
        <div class="package-card flex items-center gap-3 p-3.5 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer transition-all duration-150 hover:border-emerald-400 select-none"
            role="radio" tabindex="0" aria-checked="false"
            data-id="" data-price="0" data-name="Tanpa Paket Khusus">
            <!-- Radio dot -->
            <div class="radio-indicator flex-shrink-0 h-5 w-5 rounded-full border-2 border-stone-300 bg-white flex items-center justify-center transition-all">
                <div class="radio-dot h-2 w-2 rounded-full bg-white"></div>
            </div>
            <!-- Thumb -->
            <div class="flex-shrink-0 h-14 w-14 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center">
                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
                </svg>
            </div>
            <!-- Text -->
            <div class="flex-grow min-w-0">
                <p class="text-sm font-bold text-stone-900 leading-none">Tanpa Paket Khusus</p>
                <p class="text-[11px] text-stone-400 mt-1.5 leading-none">Tiket mandiri di loket gerbang masuk</p>
            </div>
            <!-- Price -->
            <div class="flex-shrink-0 text-right">
                <span class="text-sm font-extrabold text-emerald-700">Rp 0</span>
            </div>
        </div>

            * **/
    </script>
</x-website-layout>