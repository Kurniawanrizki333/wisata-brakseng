<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\Setting;

class ContactController extends Controller
{
    public function index()
    {
        return view('website.contact', [
            'address' => Setting::value('alamat'),
            'phone' => Setting::value('telepon'),
            'email' => Setting::value('email'),
            'googleMapsEmbed' => Setting::value('google_maps_embed'),
        ]);
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::query()->create($request->validated());

        return back()->with('success', 'Terima kasih. Kritik dan saran Anda sudah kami terima.');
    }
}
