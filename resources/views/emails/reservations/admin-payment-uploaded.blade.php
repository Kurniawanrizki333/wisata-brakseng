<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Verifikasi Pembayaran</title>
    @include('emails.reservations.partials.styles')
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="header">
                <h1 class="title">Ada Pembayaran Perlu Diverifikasi</h1>
            </div>
            <div class="content">
                <table class="table">
                    <tr><th>Kode Pemesanan</th><td>{{ $reservation->reservation_code }}</td></tr>
                    <tr><th>Nama Pelanggan</th><td>{{ $reservation->visitor_name }}</td></tr>
                    <tr><th>Email Pelanggan</th><td>{{ $reservation->email }}</td></tr>
                    <tr><th>Total Tagihan</th><td>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td></tr>
                    <tr><th>Tanggal Upload Bukti</th><td>{{ $reservation->tanggal_upload_bukti?->translatedFormat('d F Y H:i') }}</td></tr>
                </table>

                <p style="margin:22px 0;"><a class="button" href="{{ $linkAdmin }}">Buka Detail Reservasi</a></p>
            </div>
        </div>
    </div>
</body>
</html>
