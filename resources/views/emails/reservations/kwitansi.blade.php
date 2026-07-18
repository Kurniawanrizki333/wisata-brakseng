<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kwitansi Pembayaran</title>
    @include('emails.reservations.partials.styles')
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="header">
                <p style="margin:0 0 6px;">Wisata Brakseng</p>
                <h1 class="title">Pembayaran Anda Disetujui</h1>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $reservation->visitor_name }}</strong>,</p>
                <p class="muted">Pembayaran untuk reservasi Anda telah diverifikasi oleh admin. Kwitansi juga kami lampirkan dalam email ini.</p>

                <table class="table">
                    <tr><th>Nomor Kwitansi</th><td>{{ $reservation->nomor_kwitansi }}</td></tr>
                    <tr><th>Kode Pemesanan</th><td>{{ $reservation->reservation_code }}</td></tr>
                    <tr><th>Nomor Invoice</th><td>{{ $reservation->nomor_invoice }}</td></tr>
                    <tr><th>Paket</th><td>{{ $reservation->tourPackage?->name ?? 'Kunjungan Mandiri' }}</td></tr>
                    <tr><th>Tanggal Verifikasi</th><td>{{ $reservation->tanggal_verifikasi_pembayaran?->translatedFormat('d F Y H:i') }}</td></tr>
                </table>

                <div class="box">
                    <p style="margin:0 0 4px;" class="muted">Total Dibayar</p>
                    <p style="margin:0;" class="total">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
