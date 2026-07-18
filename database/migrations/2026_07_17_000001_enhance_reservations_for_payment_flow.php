<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('nomor_invoice')->nullable()->unique()->after('reservation_code');
            $table->timestamp('tanggal_invoice_dikirim')->nullable()->after('nomor_invoice');
            $table->string('invoice_dikirim_ke')->nullable()->after('tanggal_invoice_dikirim');
            $table->string('token_pembayaran')->nullable()->unique()->after('invoice_dikirim_ke');
            $table->string('bukti_pembayaran')->nullable()->after('payment_status');
            $table->timestamp('tanggal_upload_bukti')->nullable()->after('bukti_pembayaran');
            $table->text('catatan_pembayaran')->nullable()->after('tanggal_upload_bukti');
            $table->foreignId('diverifikasi_oleh')->nullable()->after('catatan_pembayaran')->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_verifikasi_pembayaran')->nullable()->after('diverifikasi_oleh');
            $table->text('alasan_penolakan')->nullable()->after('tanggal_verifikasi_pembayaran');
            $table->string('nomor_kwitansi')->nullable()->unique()->after('alasan_penolakan');
            $table->timestamp('tanggal_kwitansi_dikirim')->nullable()->after('nomor_kwitansi');
            $table->string('kwitansi_dikirim_ke')->nullable()->after('tanggal_kwitansi_dikirim');
        });

        DB::table('reservations')->orderBy('id')->get()->each(function (object $reservation): void {
            DB::table('reservations')
                ->where('id', $reservation->id)
                ->update([
                    'nomor_invoice' => $reservation->reservation_code
                        ? str_replace('RSV-', 'INV-', $reservation->reservation_code)
                        : 'INV-'.now()->format('Ymd').'-'.str_pad((string) $reservation->id, 4, '0', STR_PAD_LEFT),
                    'token_pembayaran' => Str::random(48),
                    'status' => match ($reservation->status) {
                        'confirmed' => 'pembayaran_disetujui',
                        'completed' => 'selesai',
                        'cancelled' => 'dibatalkan',
                        default => 'menunggu_pembayaran',
                    },
                    'payment_status' => match ($reservation->payment_status) {
                        'paid' => 'sudah_dibayar',
                        default => 'belum_dibayar',
                    },
                ]);
        });

        DB::table('settings')->updateOrInsert(
            ['key' => 'email_admin_pemesanan'],
            [
                'value' => config('mail.from.address'),
                'autoload' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('diverifikasi_oleh');
            $table->dropColumn([
                'nomor_invoice',
                'tanggal_invoice_dikirim',
                'invoice_dikirim_ke',
                'token_pembayaran',
                'bukti_pembayaran',
                'tanggal_upload_bukti',
                'catatan_pembayaran',
                'tanggal_verifikasi_pembayaran',
                'alasan_penolakan',
                'nomor_kwitansi',
                'tanggal_kwitansi_dikirim',
                'kwitansi_dikirim_ke',
            ]);
        });
    }
};
