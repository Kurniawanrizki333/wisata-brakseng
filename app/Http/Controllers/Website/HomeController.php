<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TourPackage;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('website.home', [
            'settings' => $this->settings(),
            'featuredDestinations' => Destination::query()->published()->featured()->latest()->limit(6)->get(),
            'tourPackages' => TourPackage::query()->published()->latest()->limit(3)->get(),
            'upcomingEvents' => Event::query()->published()->upcoming()->limit(3)->get(),
            'products' => Product::query()->published()->latest()->limit(4)->get(),
            'galleries' => Gallery::query()->latest('taken_at')->limit(8)->get(),
        ]);
    }

    private function settings(): array
    {
        return [
            'hero_title' => Setting::value('hero_title', 'Desa Wisata Sumberbrantas'),
            'hero_subtitle' => Setting::value('hero_subtitle', 'Wisata alam dan edukasi pertanian di Kota Batu.'),
            'hero_image' => Setting::value('hero_image'),
            'about' => Setting::value('about'),
            'profile_video_url' => Setting::value('profile_video_url'),
            'google_maps_embed' => Setting::value('google_maps_embed'),
        ];
    }
}
