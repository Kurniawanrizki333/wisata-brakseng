<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('reservations')
            ->whereNull('reservation_code')
            ->orWhere('reservation_code', '')
            ->orderBy('id')
            ->get()
            ->each(function (object $reservation): void {
                $kodePemesanan = 'RSV-'.now()->format('Ymd').'-'.str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT);

                DB::table('reservations')
                    ->where('id', $reservation->id)
                    ->update([
                        'reservation_code' => $kodePemesanan,
                        'nomor_invoice' => $reservation->nomor_invoice ?: str_replace('RSV-', 'INV-', $kodePemesanan),
                    ]);
            });
    }

    public function down(): void
    {
        //
    }
};
