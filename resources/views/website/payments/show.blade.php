<x-website-layout title="Pembayaran Reservasi - Desa Wisata Sumberbrantas">

    @php
        // Tentukan warna badge status secara dinamis berdasarkan teks status,
        // bukan hardcoded amber untuk semua kondisi.
        $statusText = strtolower($reservation->nama_status_pembayaran ?? '');
        if ($reservation->alasan_penolakan || str_contains($statusText, 'tolak') || str_contains($statusText, 'gagal')) {
            $statusColor = ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'];
        } elseif (str_contains($statusText, 'lunas') || str_contains($statusText, 'berhasil') || str_contains($statusText, 'diterima') || str_contains($statusText, 'terverifikasi') || str_contains($statusText, 'dikonfirmasi')) {
            $statusColor = ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'];
        } elseif (str_contains($statusText, 'verifikasi') || str_contains($statusText, 'proses') || str_contains($statusText, 'review')) {
            $statusColor = ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'];
        } else {
            $statusColor = ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'];
        }

        $buktiExt = $reservation->bukti_pembayaran ? strtolower(pathinfo($reservation->bukti_pembayaran, PATHINFO_EXTENSION)) : null;
        $buktiIsImage = in_array($buktiExt, ['jpg', 'jpeg', 'png', 'webp']);
        $buktiUrl = $reservation->bukti_pembayaran
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($reservation->bukti_pembayaran)
            : null;
        $qrisBarcode = \App\Models\Setting::value('qris_barcode');
        $qrisBarcodeUrl = $qrisBarcode ? \Illuminate\Support\Facades\Storage::disk('public')->url($qrisBarcode) : null;
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
                radial-gradient(60% 80% at 12% 0%, rgba(34, 139, 74, 0.10) 0%, rgba(34, 139, 74, 0) 60%),
                radial-gradient(50% 60% at 100% 10%, rgba(201, 169, 89, 0.08) 0%, rgba(201, 169, 89, 0) 60%),
                #FAFAF5;
        }

        .sb-card {
            border-radius: 1.5rem;
            box-shadow: 0 1px 2px rgba(20, 83, 45, 0.05);
        }

        .sb-dropzone {
            border: 2px dashed #d6d3d1;
            border-radius: 1rem;
            transition: border-color .2s ease, background-color .2s ease;
        }

        .sb-dropzone.is-dragover {
            border-color: #059669;
            background-color: #ecfdf5;
        }

        .sb-dropzone input[type="file"] {
            opacity: 0;
            position: absolute;
            inset: 0;
            cursor: pointer;
        }
    </style>

    <section class="sb-font-body sb-hero-bg min-h-screen py-10 sm:py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">Pembayaran Reservasi</p>
                <h1 class="sb-font-display mt-2 text-3xl font-semibold tracking-tight text-emerald-950">Invoice
                    {{ $reservation->nomor_invoice }}
                </h1>
                <p class="mt-2 text-sm text-stone-500">Silakan lakukan pembayaran sesuai total tagihan, lalu unggah
                    bukti pembayaran di halaman ini.</p>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">
                    <svg class="h-5 w-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
                <div class="sb-card border border-stone-100 bg-white p-6">
                    <div
                        class="flex flex-col gap-4 border-b border-stone-100 pb-6 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Kode Pemesanan</p>
                            <p class="mt-1 text-xl font-black text-emerald-900">{{ $reservation->reservation_code }}</p>
                        </div>
                        <span
                            class="inline-flex w-fit items-center gap-1.5 rounded-full {{ $statusColor['bg'] }} px-3 py-1.5 text-xs font-bold {{ $statusColor['text'] }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $statusColor['dot'] }}"></span>
                            {{ $reservation->nama_status_pembayaran }}
                        </span>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Nama Pelanggan</p>
                            <p class="mt-1 font-bold text-stone-900">{{ $reservation->visitor_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Email</p>
                            <p class="mt-1 font-bold text-stone-900">{{ $reservation->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Paket</p>
                            <p class="mt-1 font-bold text-stone-900">
                                {{ $reservation->tourPackage?->name ?? 'Kunjungan Mandiri' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Tanggal Reservasi</p>
                            <p class="mt-1 font-bold text-stone-900">
                                {{ $reservation->reservation_date->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Jumlah Peserta</p>
                            <p class="mt-1 font-bold text-stone-900">{{ $reservation->total_people }} orang</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Metode Pembayaran</p>
                            <p class="mt-1 font-bold text-stone-900">{{ $reservation->namaMetodePembayaran() }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-4 rounded-2xl bg-emerald-50 p-5">
                        <span
                            class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-white border border-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">Total Tagihan</p>
                            <p class="sb-font-display text-3xl font-semibold text-emerald-950">Rp
                                {{ number_format($reservation->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-stone-200 bg-stone-50 p-5 text-sm text-stone-600">
                        <p class="font-black uppercase tracking-widest text-stone-800 text-xs">Instruksi Pembayaran</p>
                        @if($reservation->payment_method === 'bank_transfer')
                            <div class="mt-3 rounded-xl bg-white p-4 shadow-sm border border-stone-100">
                                <p class="text-xs font-bold uppercase tracking-widest text-stone-400">Bank Mandiri</p>
                                <p class="mt-1 text-lg font-black text-emerald-800">144-00-1928374-1</p>
                                <p class="text-xs font-semibold text-stone-500">a.n. Desa Wisata Sumberbrantas</p>
                            </div>
                            <p class="mt-3">Transfer sesuai total tagihan, lalu unggah bukti pembayaran melalui form di
                                samping.</p>
                        @elseif($reservation->payment_method === 'qris')
                            <p class="mt-3">Lakukan pembayaran melalui QRIS resmi berikut, lalu unggah bukti pembayaran
                                melalui form di samping.</p>
                            @if($qrisBarcodeUrl)
                                <div class="mt-4 overflow-hidden rounded-xl border border-stone-200 bg-white p-4 shadow-sm">
                                    <p class="text-xs font-bold uppercase tracking-widest text-stone-400">QRIS Barcode</p>
                                    <img src="{{ $qrisBarcodeUrl }}" alt="QRIS Barcode Wisata Brakseng"
                                        class="mt-3 w-full max-w-xs rounded-lg border border-stone-100 object-contain">
                                    <p class="mt-3 text-[10px] italic text-stone-400">Scan barcode ini dengan aplikasi
                                        pembayaran yang mendukung QRIS.</p>
                                </div>
                            @else
                                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs text-amber-800">
                                    QRIS barcode belum diunggah oleh admin.
                                </div>
                            @endif
                        @else
                            <p class="mt-3">Pembayaran tunai dilakukan di loket. Anda tetap dapat mengunggah bukti
                                pembayaran jika sudah diarahkan oleh admin.</p>
                        @endif
                    </div>
                </div>

                <div class="sb-card border border-stone-100 bg-white p-6">
                    <h2 class="sb-font-display text-lg font-semibold text-emerald-950">Unggah Bukti Pembayaran</h2>
                    <p class="mt-1 text-xs text-stone-500">Masukkan email yang sama dengan data reservasi untuk
                        keamanan.</p>

                    @if($reservation->bukti_pembayaran)
                        <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs text-amber-800">
                            <p>
                                Bukti pembayaran terakhir diunggah pada
                                <strong>{{ $reservation->tanggal_upload_bukti?->translatedFormat('d F Y H:i') }}</strong>.
                                Anda dapat mengunggah ulang jika pembayaran sebelumnya ditolak.
                            </p>
                            <div class="mt-3">
                                @if ($buktiIsImage)
                                    <a href="{{ $buktiUrl }}" target="_blank" rel="noopener"
                                        class="block overflow-hidden rounded-lg border border-amber-200">
                                        <img src="{{ $buktiUrl }}" alt="Bukti pembayaran sebelumnya" loading="lazy"
                                            class="h-32 w-full object-cover">
                                    </a>
                                @else
                                    <a href="{{ $buktiUrl }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-2 rounded-lg bg-white border border-amber-200 px-3 py-2 font-bold text-amber-800 hover:bg-amber-100 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6 0H6.375c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        Lihat file bukti pembayaran
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($reservation->alasan_penolakan)
                        <div
                            class="mt-4 flex items-start gap-2.5 rounded-xl border border-red-200 bg-red-50 p-4 text-xs text-red-700">
                            <svg class="h-4 w-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <div>
                                <strong class="block mb-0.5">Alasan Penolakan</strong>
                                {{ $reservation->alasan_penolakan }}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pembayaran.store', $reservation->token_pembayaran) }}"
                        enctype="multipart/form-data" class="mt-6 space-y-4" id="uploadForm">
                        @csrf

                        <div>
                            <label for="email"
                                class="text-xs font-bold uppercase tracking-widest text-stone-500">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $reservation->email) }}"
                                required
                                class="mt-1 w-full rounded-xl border border-stone-200 bg-stone-50 px-3 py-2.5 text-sm outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition">
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-xs font-bold uppercase tracking-widest text-stone-500">Bukti
                                Pembayaran</label>

                            <div class="sb-dropzone relative mt-1 flex flex-col items-center justify-center gap-2 px-4 py-8 text-center"
                                id="dropzone">
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                    accept=".jpg,.jpeg,.png,.pdf" required aria-describedby="err_bukti">
                                <svg class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <p class="text-xs font-bold text-stone-600" id="dropzone_text">Klik atau seret file ke
                                    sini</p>
                                <p class="text-[10px] text-stone-400">JPG, PNG, atau PDF · maks. sesuai ketentuan admin
                                </p>
                            </div>
                            <p id="err_bukti" class="mt-1 text-xs text-red-600">@error('bukti_pembayaran')
                            {{ $message }} @enderror
                            </p>
                        </div>

                        <div>
                            <label for="catatan_pembayaran"
                                class="text-xs font-bold uppercase tracking-widest text-stone-500">Catatan
                                Pembayaran</label>
                            <textarea id="catatan_pembayaran" name="catatan_pembayaran" rows="3"
                                class="mt-1 w-full rounded-xl border border-stone-200 bg-stone-50 px-3 py-2.5 text-sm outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition"
                                placeholder="Contoh: transfer atas nama Budi Santoso">{{ old('catatan_pembayaran') }}</textarea>
                            @error('catatan_pembayaran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" id="uploadSubmitBtn"
                            class="w-full flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-black uppercase tracking-wider text-white shadow-sm hover:bg-emerald-800 active:scale-[0.98] transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                            <span class="btn-label">Kirim Bukti Pembayaran</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('bukti_pembayaran');
            const dropzoneText = document.getElementById('dropzone_text');
            const form = document.getElementById('uploadForm');
            const submitBtn = document.getElementById('uploadSubmitBtn');

            function showFileName(file) {
                if (!file) return;
                const sizeKb = Math.round(file.size / 1024);
                dropzoneText.textContent = file.name + ' (' + sizeKb + ' KB) — siap diunggah';
            }

            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files[0]) showFileName(fileInput.files[0]);
            });

            ['dragenter', 'dragover'].forEach(evt => {
                dropzone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropzone.classList.add('is-dragover');
                });
            });
            ['dragleave', 'drop'].forEach(evt => {
                dropzone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('is-dragover');
                });
            });
            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                if (dt && dt.files && dt.files[0]) {
                    fileInput.files = dt.files;
                    showFileName(dt.files[0]);
                }
            });

            form.addEventListener('submit', function () {
                if (form.checkValidity()) {
                    submitBtn.disabled = true;
                }
            });
        })();
    </script>
</x-website-layout>