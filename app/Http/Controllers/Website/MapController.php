<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Setting;

class MapController extends Controller
{
    public function __invoke()
    {
        return view('website.map', [
            'destinations' => Destination::query()->published()->whereNotNull('latitude')->whereNotNull('longitude')->get(),
            'googleMapsEmbed' => Setting::value('google_maps_embed'),
        ]);
    }
}
