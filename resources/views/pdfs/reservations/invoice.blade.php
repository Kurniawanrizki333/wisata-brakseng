<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $reservation->nomor_invoice }}</title>
    @include('pdfs.partials.styles')
</head>

<body>
    <div class="wrap">
        <p class="brand">Wisata Brakseng</p>
        <h1 class="doc-title">Invoice Reservasi</h1>
        <p class="doc-sub">
            {{ $reservation->nomor_invoice }} &middot; diterbitkan {{ now()->translatedFormat('d F Y') }}
            &middot; <span class="status-badge pending">Menunggu Pembayaran</span>
        </p>

        <table class="info">
            <tr>
                <th>Kode Pemesanan</th>
                <td>{{ $reservation->reservation_code }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $reservation->visitor_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $reservation->email }}</td>
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
                <th>Jumlah Peserta</th>
                <td>{{ $reservation->total_people }} orang</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $reservation->namaMetodePembayaran() }}</td>
            </tr>
        </table>

        <div class="total-box">
            <p class="total-label">Total Tagihan</p>
            <p class="total-amount">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
        </div>

        <p class="footer-note">
            <strong>Link Pembayaran:</strong> {{ $linkPembayaran }}<br>
            Selesaikan pembayaran melalui link di atas, lalu unggah bukti pembayaran agar tim kami dapat memverifikasi
            reservasi Anda.
        </p>

        <p class="footer-brand">
            Dokumen ini dibuat otomatis oleh sistem Wisata Brakseng dan sah tanpa tanda tangan basah.
        </p>
    </div>
</body>

</html>