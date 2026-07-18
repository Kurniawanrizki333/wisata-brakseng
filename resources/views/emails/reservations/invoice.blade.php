<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Reservasi</title>
    @include('emails.reservations.partials.styles')
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="header">
                <p style="margin:0 0 6px;">Wisata Brakseng</p>
                <h1 class="title">Invoice Reservasi Anda</h1>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $reservation->visitor_name }}</strong>,</p>
                <p class="muted">Reservasi Anda berhasil dibuat. Silakan selesaikan pembayaran melalui link berikut.</p>

                <p style="margin:22px 0;"><a class="button" href="{{ $linkPembayaran }}">Bayar Sekarang</a></p>

                <table class="table">
                    <tr><th>Nomor Invoice</th><td>{{ $reservation->nomor_invoice }}</td></tr>
                    <tr><th>Kode Pemesanan</th><td>{{ $reservation->reservation_code }}</td></tr>
                    <tr><th>Paket</th><td>{{ $reservation->tourPackage?->name ?? 'Kunjungan Mandiri' }}</td></tr>
                    <tr><th>Tanggal Reservasi</th><td>{{ $reservation->reservation_date->translatedFormat('d F Y') }}</td></tr>
                    <tr><th>Jumlah Peserta</th><td>{{ $reservation->total_people }} orang</td></tr>
                    <tr><th>Metode Pembayaran</th><td>{{ $reservation->namaMetodePembayaran() }}</td></tr>
                </table>

                <div class="box">
                    <p style="margin:0 0 4px;" class="muted">Total Tagihan</p>
                    <p style="margin:0;" class="total">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                </div>

                <p class="muted" style="font-size:13px;">Invoice juga kami lampirkan dalam email ini. Setelah membayar, unggah bukti pembayaran melalui tombol Bayar Sekarang.</p>
            </div>
        </div>
    </div>
</body>
</html>
