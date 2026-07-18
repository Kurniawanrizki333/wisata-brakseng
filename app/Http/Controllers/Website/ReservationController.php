<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\TourPackage;
use App\Services\ReservationNotificationService;

class ReservationController extends Controller
{
    public function create()
    {
        return view('website.reservations.create', [
            'tourPackages' => TourPackage::query()->published()->orderBy('name')->get(),
            'selectedPackage' => request('package'),
        ]);
    }

    public function store(StoreReservationRequest $request, ReservationNotificationService $notificationService)
    {
        $reservation = Reservation::query()->create([
            ...$request->validated(),
            'status' => Reservation::STATUS_MENUNGGU_PEMBAYARAN,
            'payment_status' => Reservation::PEMBAYARAN_BELUM_DIBAYAR,
        ]);

        $notificationService->kirimInvoice($reservation);

        $formattedPrice = number_format($reservation->total_price, 0, ',', '.');
        $message = "Reservasi berhasil dibuat dengan Kode Pemesanan: <strong>{$reservation->reservation_code}</strong>. Invoice sudah dikirim ke email Anda beserta link pembayaran, Jika tidak muncul cek dibagian spam email atau hubungi admin. Total tagihan sebesar <strong>Rp {$formattedPrice}</strong>.";

        return back()->with('success', $message)
            ->with('reservation_code', $reservation->reservation_code)
            ->with('nomor_invoice', $reservation->nomor_invoice)
            ->with('total_price', $reservation->total_price)
            ->with('payment_method', $reservation->payment_method)
            ->with('payment_url', route('pembayaran.show', $reservation->token_pembayaran));
    }
}
