<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pembayaran Ditolak</title>
    @include('emails.reservations.partials.styles')
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="header" style="background:#b91c1c;">
                <h1 class="title">Pembayaran Belum Dapat Disetujui</h1>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $reservation->visitor_name }}</strong>,</p>
                <p class="muted">Bukti pembayaran untuk reservasi <strong>{{ $reservation->reservation_code }}</strong> belum dapat kami setujui.</p>

                @if($reservation->alasan_penolakan)
                    <div class="box" style="background:#fef2f2;border-color:#fecaca;">
                        <p style="margin:0 0 6px;font-weight:700;color:#991b1b;">Alasan Penolakan</p>
                        <p style="margin:0;">{{ $reservation->alasan_penolakan }}</p>
                    </div>
                @endif

                <p style="margin:22px 0;"><a class="button" href="{{ $linkPembayaran }}">Upload Ulang Bukti Pembayaran</a></p>
                <p class="muted" style="font-size:13px;">Silakan perbaiki bukti pembayaran melalui link di atas. Admin akan melakukan verifikasi ulang setelah bukti baru dikirim.</p>
            </div>
        </div>
    </div>
</body>
</html>
