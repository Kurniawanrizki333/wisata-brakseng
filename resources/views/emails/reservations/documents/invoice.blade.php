<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $reservation->nomor_invoice }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1c1917; margin: 32px; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #047857; padding-bottom: 18px; }
        h1 { margin: 0; color: #065f46; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        th, td { border-bottom: 1px solid #ddd6d0; padding: 12px 0; text-align: left; }
        .total { margin-top: 24px; padding: 18px; background: #ecfdf5; border: 1px solid #bbf7d0; font-size: 24px; font-weight: 800; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>INVOICE</h1>
            <p>Wisata Brakseng<br>Desa Sumberbrantas, Bumiaji, Kota Batu</p>
        </div>
        <div>
            <p><strong>Nomor Invoice:</strong> {{ $reservation->nomor_invoice }}</p>
            <p><strong>Kode Pemesanan:</strong> {{ $reservation->reservation_code }}</p>
            <p><strong>Tanggal Terbit:</strong> {{ $reservation->created_at->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>

    <table>
        <tr><th>Nama Pelanggan</th><td>{{ $reservation->visitor_name }}</td></tr>
        <tr><th>Email</th><td>{{ $reservation->email }}</td></tr>
        <tr><th>Paket</th><td>{{ $reservation->tourPackage?->name ?? 'Kunjungan Mandiri' }}</td></tr>
        <tr><th>Tanggal Reservasi</th><td>{{ $reservation->reservation_date->translatedFormat('d F Y') }}</td></tr>
        <tr><th>Jumlah Peserta</th><td>{{ $reservation->total_people }} orang</td></tr>
        <tr><th>Metode Pembayaran</th><td>{{ $reservation->namaMetodePembayaran() }}</td></tr>
    </table>

    <div class="total">Total Tagihan: Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</div>

    <p>Link pembayaran: <a href="{{ $linkPembayaran }}">{{ $linkPembayaran }}</a></p>
</body>
</html>
