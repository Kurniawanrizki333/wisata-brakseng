<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $reservation->nomor_kwitansi }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1c1917; margin: 32px; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #047857; padding-bottom: 18px; }
        h1 { margin: 0; color: #065f46; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        th, td { border-bottom: 1px solid #ddd6d0; padding: 12px 0; text-align: left; }
        .stamp { margin-top: 24px; padding: 18px; background: #ecfdf5; border: 1px solid #bbf7d0; font-size: 24px; font-weight: 800; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>KWITANSI</h1>
            <p>Wisata Brakseng<br>Desa Sumberbrantas, Bumiaji, Kota Batu</p>
        </div>
        <div>
            <p><strong>Nomor Kwitansi:</strong> {{ $reservation->nomor_kwitansi }}</p>
            <p><strong>Kode Pemesanan:</strong> {{ $reservation->reservation_code }}</p>
            <p><strong>Nomor Invoice:</strong> {{ $reservation->nomor_invoice }}</p>
        </div>
    </div>

    <table>
        <tr><th>Telah Diterima Dari</th><td>{{ $reservation->visitor_name }}</td></tr>
        <tr><th>Untuk Pembayaran</th><td>{{ $reservation->tourPackage?->name ?? 'Kunjungan Mandiri' }}</td></tr>
        <tr><th>Tanggal Reservasi</th><td>{{ $reservation->reservation_date->translatedFormat('d F Y') }}</td></tr>
        <tr><th>Metode Pembayaran</th><td>{{ $reservation->namaMetodePembayaran() }}</td></tr>
        <tr><th>Tanggal Verifikasi</th><td>{{ $reservation->tanggal_verifikasi_pembayaran?->translatedFormat('d F Y H:i') }}</td></tr>
    </table>

    <div class="stamp">Total Dibayar: Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</div>
</body>
</html>
