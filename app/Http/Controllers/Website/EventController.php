<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('website.events.index', [
            'events' => Event::query()
                ->published()
                ->orderByRaw('CASE WHEN start_date >= ? THEN 0 ELSE 1 END', [now()])
                ->orderBy('start_date')
                ->paginate(9),
        ]);
    }

    public function show(Event $event)
    {
        abort_unless($event->status === Event::STATUS_PUBLISHED, 404);

        return view('website.events.show', ['event' => $event]);
    }
}
