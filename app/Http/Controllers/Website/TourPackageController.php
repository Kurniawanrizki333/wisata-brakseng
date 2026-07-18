<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;

class TourPackageController extends Controller
{
    public function index()
    {
        return view('website.tour-packages.index', [
            'tourPackages' => TourPackage::query()->published()->latest()->paginate(9),
        ]);
    }

    public function show(TourPackage $tourPackage)
    {
        abort_unless($tourPackage->status === TourPackage::STATUS_PUBLISHED, 404);

        return view('website.tour-packages.show', [
            'tourPackage' => $tourPackage,
        ]);
    }
}
