<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function index()
    {
        return view('website.destinations.index', [
            'destinations' => Destination::query()
                ->published()
                ->latest()
                ->paginate(9),
        ]);
    }

    public function show(Destination $destination)
    {
        abort_unless($destination->status === Destination::STATUS_PUBLISHED, 404);

        return view('website.destinations.show', [
            'destination' => $destination->load('images'),
        ]);
    }
}
