<?php

namespace App\Services;

use App\Filament\Resources\Reservations\ReservationResource;
use App\Models\Reservation;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class ReservationNotificationService
{
    public function kirimInvoice(Reservation $reservation): void
    {
        $reservation->loadMissing('tourPackage');

        $linkPembayaran = route('pembayaran.show', $reservation->token_pembayaran);
        $lampiranPdf = $this->buatPdfInvoice($reservation, $linkPembayaran);

        Mail::send('emails.reservations.invoice', [
            'reservation' => $reservation,
            'linkPembayaran' => $linkPembayaran,
        ], function ($message) use ($reservation, $lampiranPdf): void {
            $message
                ->to($reservation->email, $reservation->visitor_name)
                ->subject("Invoice Reservasi {$reservation->nomor_invoice}")
                ->attachData($lampiranPdf, "{$reservation->nomor_invoice}.pdf", [
                    'mime' => 'application/pdf',
                ]);
        });

        $reservation->forceFill([
            'tanggal_invoice_dikirim' => now(),
            'invoice_dikirim_ke' => $reservation->email,
        ])->save();
    }

    public function kirimNotifikasiAdmin(Reservation $reservation): void
    {
        $reservation->loadMissing('tourPackage');

        $emails = $this->emailAdminPemesanan();

        Mail::send('emails.reservations.admin-payment-uploaded', [
            'reservation' => $reservation,
            'linkAdmin' => ReservationResource::getUrl('view', ['record' => $reservation]),
        ], function ($message) use ($reservation, $emails): void {
            $message
                ->to($emails)
                ->subject("Verifikasi Pembayaran {$reservation->reservation_code}");
        });
    }

    public function kirimKwitansi(Reservation $reservation): void
    {
        $reservation->loadMissing('tourPackage');

        if (blank($reservation->nomor_kwitansi)) {
            $reservation->forceFill([
                'nomor_kwitansi' => 'KWT-' . now()->format('Ymd') . '-' . str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT),
            ])->save();
        }

        $lampiranPdf = $this->buatPdfKwitansi($reservation);

        Mail::send('emails.reservations.kwitansi', [
            'reservation' => $reservation,
        ], function ($message) use ($reservation, $lampiranPdf): void {
            $message
                ->to($reservation->email, $reservation->visitor_name)
                ->subject("Kwitansi Pembayaran {$reservation->nomor_kwitansi}")
                ->attachData($lampiranPdf, "{$reservation->nomor_kwitansi}.pdf", [
                    'mime' => 'application/pdf',
                ]);
        });

        $reservation->forceFill([
            'tanggal_kwitansi_dikirim' => now(),
            'kwitansi_dikirim_ke' => $reservation->email,
        ])->save();
    }

    public function kirimPenolakan(Reservation $reservation): void
    {
        Mail::send('emails.reservations.payment-rejected', [
            'reservation' => $reservation,
            'linkPembayaran' => route('pembayaran.show', $reservation->token_pembayaran),
        ], function ($message) use ($reservation): void {
            $message
                ->to($reservation->email, $reservation->visitor_name)
                ->subject("Pembayaran Ditolak {$reservation->reservation_code}");
        });
    }

    /**
     * Mengembalikan daftar email admin pemesanan.
     * Nilai setting bisa diisi satu atau lebih email dipisah koma,
     * misalnya: "admin@desa.com, manager@desa.com"
     *
     * @return array<int, array{address: string, name: string}>
     */
    private function emailAdminPemesanan(): array
    {
        $raw = Setting::value('email_admin_pemesanan')
            ?: config('mail.from.address')
            ?: 'admin@example.com';

        return collect(explode(',', $raw))
            ->map(fn (string $email) => ['address' => trim($email), 'name' => 'Admin'])
            ->filter(fn (array $entry) => filter_var($entry['address'], FILTER_VALIDATE_EMAIL))
            ->values()
            ->all();
    }

    private function buatPdfInvoice(Reservation $reservation, string $linkPembayaran): string
    {
        return Pdf::loadView('pdfs.reservations.invoice', [
            'reservation' => $reservation,
            'linkPembayaran' => $linkPembayaran,
        ])->setPaper('a4', 'portrait')->output();
    }

    private function buatPdfKwitansi(Reservation $reservation): string
    {
        return Pdf::loadView('pdfs.reservations.kwitansi', [
            'reservation' => $reservation,
        ])->setPaper('a4', 'portrait')->output();
    }
}