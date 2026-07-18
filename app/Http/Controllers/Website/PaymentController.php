<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentProofRequest;
use App\Models\Reservation;
use App\Services\ReservationNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(string $token): View
    {
        return view('website.payments.show', [
            'reservation' => $this->findReservation($token),
        ]);
    }

    public function store(
        StorePaymentProofRequest $request,
        string $token,
        ReservationNotificationService $notificationService,
    ): RedirectResponse {
        $reservation = $this->findReservation($token);

        if (strtolower($request->validated('email')) !== strtolower($reservation->email)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email tidak sesuai dengan data reservasi.']);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $reservation->update([
            'bukti_pembayaran' => $path,
            'tanggal_upload_bukti' => now(),
            'catatan_pembayaran' => $request->validated('catatan_pembayaran'),
            'status' => Reservation::STATUS_MENUNGGU_VERIFIKASI,
            'payment_status' => Reservation::PEMBAYARAN_MENUNGGU_VERIFIKASI,
            'alasan_penolakan' => null,
        ]);

        $notificationService->kirimNotifikasiAdmin($reservation);

        return redirect()
            ->route('pembayaran.show', $reservation->token_pembayaran)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Admin akan segera melakukan verifikasi.');
    }

    private function findReservation(string $token): Reservation
    {
        return Reservation::query()
            ->with('tourPackage')
            ->where('token_pembayaran', $token)
            ->firstOrFail();
    }
}
