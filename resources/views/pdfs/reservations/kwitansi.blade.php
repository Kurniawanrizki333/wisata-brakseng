<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Kwitansi {{ $reservation->nomor_kwitansi }}</title>
    @include('pdfs.partials.styles')
</head>

<body>
    <div class="wrap">
        <p class="brand">Wisata Brakseng</p>
        <h1 class="doc-title">Kwitansi Pembayaran</h1>
        <p class="doc-sub">
            {{ $reservation->nomor_kwitansi }} &middot; diterbitkan {{ now()->translatedFormat('d F Y') }}
            &middot; <span class="status-badge paid">Lunas</span>
        </p>

        <table class="info">
            <tr>
                <th>Kode Pemesanan</th>
                <td>{{ $reservation->reservation_code }}</td>
            </tr>
            <tr>
                <th>Nomor Invoice</th>
                <td>{{ $reservation->nomor_invoice }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $reservation->visitor_name }}</td>
            </tr>
            <tr>
                <th>Paket</th>
                <td>{{ $reservation->tourPackage?->name ?? 'Kunjungan Mandiri' }}</td>
            </tr>
            <tr>
                <th>Tanggal Reservasi</th>
                <td>{{ $reservation->reservation_date->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Verifikasi</th>
                <td>{{ $reservation->tanggal_verifikasi_pembayaran?->translatedFormat('d F Y H:i') }}</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $reservation->namaMetodePembayaran() }}</td>
            </tr>
        </table>

        <div class="total-box">
            <p class="total-label">Total Dibayar</p>
            <p class="total-amount">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
        </div>

        <p class="footer-note">
            Kwitansi ini adalah bukti sah bahwa pembayaran reservasi di atas telah kami terima dan verifikasi.
        </p>

        <p class="footer-brand">
            Dokumen ini dibuat otomatis oleh sistem Wisata Brakseng dan sah tanpa tanda tangan basah.
        </p>
    </div>
</body>

</html>