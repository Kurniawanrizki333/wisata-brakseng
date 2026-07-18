<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';

    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';

    public const STATUS_PEMBAYARAN_DISETUJUI = 'pembayaran_disetujui';

    public const STATUS_PEMBAYARAN_DITOLAK = 'pembayaran_ditolak';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_DIBATALKAN = 'dibatalkan';

    public const PEMBAYARAN_BELUM_DIBAYAR = 'belum_dibayar';

    public const PEMBAYARAN_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';

    public const PEMBAYARAN_SUDAH_DIBAYAR = 'sudah_dibayar';

    public const PEMBAYARAN_DITOLAK = 'ditolak';

    protected $fillable = [
        'tour_package_id',
        'visitor_name',
        'email',
        'phone',
        'reservation_date',
        'total_people',
        'notes',
        'status',
        'reservation_code',
        'nomor_invoice',
        'tanggal_invoice_dikirim',
        'invoice_dikirim_ke',
        'token_pembayaran',
        'total_price',
        'payment_method',
        'payment_status',
        'bukti_pembayaran',
        'tanggal_upload_bukti',
        'catatan_pembayaran',
        'diverifikasi_oleh',
        'tanggal_verifikasi_pembayaran',
        'alasan_penolakan',
        'nomor_kwitansi',
        'tanggal_kwitansi_dikirim',
        'kwitansi_dikirim_ke',
    ];

    protected static function booted(): void
    {
        static::creating(function (Reservation $reservation) {
            if (empty($reservation->reservation_code)) {
                $reservation->reservation_code = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }

            if (empty($reservation->nomor_invoice)) {
                $reservation->nomor_invoice = str_replace('RSV-', 'INV-', $reservation->reservation_code);
            }

            if (empty($reservation->token_pembayaran)) {
                $reservation->token_pembayaran = Str::random(48);
            }

            if (!$reservation->total_price && $reservation->tour_package_id) {
                // Since TourPackage is in the same namespace App\Models, we can reference it directly
                $package = TourPackage::find($reservation->tour_package_id);
                if ($package) {
                    $reservation->total_price = $package->price * ($reservation->total_people ?? 1);
                }
            }

            $reservation->status ??= self::STATUS_MENUNGGU_PEMBAYARAN;
            $reservation->payment_status ??= self::PEMBAYARAN_BELUM_DIBAYAR;
        });
    }

    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'total_people' => 'integer',
            'total_price' => 'decimal:2',
            'tanggal_invoice_dikirim' => 'datetime',
            'tanggal_upload_bukti' => 'datetime',
            'tanggal_verifikasi_pembayaran' => 'datetime',
            'tanggal_kwitansi_dikirim' => 'datetime',
        ];
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function getBuktiPembayaranUrlAttribute(): ?string
    {
        return $this->bukti_pembayaran ? Storage::disk('public')->url($this->bukti_pembayaran) : null;
    }

    public function getNamaStatusAttribute(): string
    {
        return self::statusOptions()[$this->status] ?? $this->status;
    }

    public function getNamaStatusPembayaranAttribute(): string
    {
        return self::paymentStatusOptions()[$this->payment_status] ?? $this->payment_status;
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_PEMBAYARAN_DISETUJUI => 'Pembayaran Disetujui',
            self::STATUS_PEMBAYARAN_DITOLAK => 'Pembayaran Ditolak',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
        ];
    }

    public static function paymentStatusOptions(): array
    {
        return [
            self::PEMBAYARAN_BELUM_DIBAYAR => 'Belum Dibayar',
            self::PEMBAYARAN_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::PEMBAYARAN_SUDAH_DIBAYAR => 'Sudah Dibayar',
            self::PEMBAYARAN_DITOLAK => 'Ditolak',
        ];
    }

    public static function paymentMethodOptions(): array
    {
        return [
            'bank_transfer' => 'Transfer Bank (Mandiri)',
            'qris' => 'QRIS',
            'cash' => 'Tunai di Loket',
        ];
    }

    public function namaMetodePembayaran(): string
    {
        return self::paymentMethodOptions()[$this->payment_method] ?? $this->payment_method;
    }
}
