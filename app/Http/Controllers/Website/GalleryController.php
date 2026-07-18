<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        return view('website.galleries.index', [
            'galleries' => Gallery::query()->latest('taken_at')->paginate(12),
            'categories' => Gallery::query()->distinct()->pluck('category')->filter()->values(),
        ]);
    }
}
