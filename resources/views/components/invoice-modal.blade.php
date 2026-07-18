@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;

    $qrisBarcode = Setting::value('qris_barcode');
    $qrisBarcodeUrl = $qrisBarcode ? Storage::disk('public')->url($qrisBarcode) : null;
@endphp

<div class="relative mx-auto max-w-4xl overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-lg" id="invoice-print-area">

    {{-- Inline print CSS --}}
    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }
            #invoice-print-area, #invoice-print-area * {
                visibility: visible !important;
            }
            #invoice-print-area {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                background: white !important;
                color: black !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                padding: 12px !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-border-b {
                border-bottom: 2px solid #e5e7eb !important;
            }
        }
    </style>

    {{-- Accent top border --}}
    <div class="h-1.5 bg-gradient-to-r from-emerald-600 via-emerald-500 to-emerald-600 no-print"></div>

    <div class="p-8 sm:p-10">

        {{-- Header --}}
        <div class="flex flex-col gap-6 border-b border-stone-100 pb-7 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-emerald-600 text-lg font-black text-white shadow-sm">
                        B
                    </div>
                    <div>
                        <h1 class="text-xl font-black leading-none tracking-tight text-emerald-950">WISATA BRAKSENG</h1>
                        <p class="mt-1.5 text-xs font-semibold text-stone-500">Sumberbrantas, Bumiaji, Kota Batu</p>
                    </div>
                </div>
                <p class="mt-4 max-w-xs text-[11px] leading-relaxed text-stone-400">
                    Desa Wisata Sumberbrantas, Kecamatan Bumiaji, Kota Batu, Jawa Timur<br>
                    info@sumberbrantas.id &nbsp;&middot;&nbsp; +62 812-3456-7890
                </p>
            </div>

            <div class="flex flex-col items-start gap-3 sm:items-end">
                <div class="flex items-center gap-2">
                    <h2 class="text-2xl font-black uppercase tracking-widest text-stone-200">Invoice</h2>
                    @if ($reservation->payment_status === \App\Models\Reservation::PEMBAYARAN_SUDAH_DIBAYAR)
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-200">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            Sudah Dibayar
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700 ring-1 ring-inset ring-amber-200">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Belum Dibayar
                        </span>
                    @endif
                </div>
                <div class="text-left text-sm sm:text-right">
                    <span class="text-stone-400">Nomor Invoice</span>
                    <span class="ml-1 font-bold tracking-wide text-emerald-800">{{ $reservation->nomor_invoice ?? $reservation->reservation_code }}</span>
                </div>
                <p class="text-xs text-stone-400">Tanggal Terbit: {{ $reservation->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        {{-- Bill-to / visit info --}}
        <div class="grid grid-cols-1 gap-8 border-b border-stone-100 py-7 md:grid-cols-2">
            <div>
                <h3 class="mb-3 text-[11px] font-bold uppercase tracking-widest text-emerald-600">Ditagihkan Kepada</h3>
                <p class="text-base font-extrabold text-stone-900">{{ $reservation->visitor_name }}</p>
                <div class="mt-2.5 space-y-1.5 text-sm text-stone-600">
                    <p class="flex items-center gap-2">
                        <svg class="h-4 w-4 flex-none text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $reservation->email }}
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="h-4 w-4 flex-none text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $reservation->phone }}
                    </p>
                </div>
            </div>

            <div class="md:text-right">
                <h3 class="mb-3 text-[11px] font-bold uppercase tracking-widest text-emerald-600">Info Kunjungan</h3>
                <dl class="space-y-2.5 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-stone-400">Tanggal Kunjungan</dt>
                        <dd class="font-bold text-stone-800">{{ $reservation->reservation_date->format('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-stone-400">Metode Pembayaran</dt>
                        <dd class="font-bold text-stone-800">
                            @if ($reservation->payment_method === 'bank_transfer')
                                Transfer Bank (Mandiri)
                            @elseif ($reservation->payment_method === 'qris')
                                QRIS (QR Code)
                            @else
                                Bayar di Loket (Cash)
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Items --}}
        <div class="py-7">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-emerald-600 text-xs font-bold uppercase tracking-wider text-white">
                        <th class="rounded-l-lg py-3 px-4">Deskripsi Layanan / Item</th>
                        <th class="w-36 py-3 px-4 text-right">Harga / Orang</th>
                        <th class="w-28 py-3 px-4 text-center">Jumlah Peserta</th>
                        <th class="w-36 rounded-r-lg py-3 px-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="print-border-b border-b border-stone-200">
                        <td class="py-5 px-4">
                            <p class="font-bold text-stone-900">
                                {{ $reservation->tourPackage ? $reservation->tourPackage->name : 'Tiket Masuk Kunjungan Mandiri' }}
                            </p>
                            <p class="mt-1 text-xs text-stone-400">
                                @if ($reservation->tourPackage)
                                    Durasi: {{ $reservation->tourPackage->duration }} &middot; Termasuk fasilitas standar pemandu & dokumentasi dasar
                                @else
                                    Kunjungan mandiri tanpa fasilitas paket khusus wisata Brakseng
                                @endif
                            </p>
                        </td>
                        <td class="py-5 px-4 text-right font-medium text-stone-600">
                            Rp {{ number_format($reservation->tourPackage ? $reservation->tourPackage->price : 0, 0, ',', '.') }}
                        </td>
                        <td class="py-5 px-4 text-center font-bold text-stone-700">
                            {{ $reservation->total_people }} Orang
                        </td>
                        <td class="py-5 px-4 text-right font-extrabold text-emerald-900">
                            Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Payment guidance + totals --}}
        <div class="grid grid-cols-1 items-start gap-8 border-t border-stone-100 pt-7 md:grid-cols-2">
            <div>
                @if ($reservation->payment_status !== \App\Models\Reservation::PEMBAYARAN_SUDAH_DIBAYAR && $reservation->payment_method === 'bank_transfer')
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4 text-xs text-stone-600">
                        <span class="mb-1 block font-bold text-emerald-900">Panduan Pembayaran Transfer</span>
                        <p class="leading-relaxed">Silakan transfer nominal total tagihan ke rekening di bawah ini:</p>
                        <div class="mt-3 inline-block rounded-lg border border-emerald-200 bg-white px-4 py-2.5">
                            <p class="text-[9px] font-bold uppercase tracking-wide text-stone-400">Rekening Resmi Wisata</p>
                            <p class="mt-1 font-black tracking-wide text-emerald-800">BANK MANDIRI: 144-00-1928374-1</p>
                            <p class="text-[10px] font-medium text-stone-600">a.n. Desa Wisata Sumberbrantas</p>
                        </div>
                        <p class="mt-3 text-[10px] italic text-stone-400">*Setelah transfer, unggah bukti pembayaran melalui link pembayaran di email invoice.</p>
                    </div>
                @elseif ($reservation->payment_status !== \App\Models\Reservation::PEMBAYARAN_SUDAH_DIBAYAR && $reservation->payment_method === 'qris')
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4 text-xs text-stone-600">
                        <span class="mb-1 block font-bold text-emerald-900">Metode QRIS Digital</span>
                        <p class="leading-relaxed">Silakan scan barcode QRIS berikut dan selesaikan pembayaran, lalu unggah bukti pembayaran melalui link pembayaran di email invoice.</p>
                        @if ($qrisBarcodeUrl)
                            <div class="mt-3 overflow-hidden rounded-lg border border-emerald-200 bg-white p-3">
                                <img src="{{ $qrisBarcodeUrl }}" alt="QRIS Barcode Wisata Brakseng" class="w-full max-w-xs rounded-md border border-stone-100 object-contain">
                            </div>
                        @endif
                    </div>
                @else
                    <div class="rounded-xl border border-stone-200 bg-stone-50 p-4 text-xs text-stone-600">
                        <span class="mb-1 block font-bold text-stone-800">Catatan Invoice</span>
                        <p class="leading-relaxed">Terima kasih telah memilih Wisata Brakseng sebagai destinasi perjalanan Anda. Untuk bantuan teknis atau pertanyaan, hubungi admin di +62 812-3456-7890.</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-col items-stretch sm:items-end">
                <div class="w-full space-y-2 text-sm sm:w-72">
                    <div class="flex justify-between font-medium text-stone-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-medium text-stone-500">
                        <span>Pajak (0%)</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="my-2 border-t border-stone-100"></div>
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 px-3 py-2.5">
                        <span class="text-sm font-black uppercase text-stone-700">Total Tagihan</span>
                        <span class="text-xl font-black tracking-tight text-emerald-800">
                            Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if ($reservation->notes)
            <div class="mt-6 rounded-lg border border-stone-200 bg-stone-50 p-4 text-xs text-stone-600">
                <span class="mb-1.5 block font-bold text-stone-800">Permintaan / Catatan Khusus Pengunjung</span>
                <p class="leading-relaxed">{{ $reservation->notes }}</p>
            </div>
        @endif

        {{-- Actions --}}
        <div class="no-print mt-8 flex justify-end gap-3 border-t border-stone-100 pt-6">
            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-xs font-black uppercase tracking-wider text-white shadow transition hover:bg-emerald-700">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.82l2.68-2.68m0 0l2.68 2.68M9.4 11.14v7.86M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM19.5 8.25V18a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 18V8.25m15 0V6a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6v2.25" />
                </svg>
                Cetak Invoice
            </button>
        </div>
    </div>
</div>
