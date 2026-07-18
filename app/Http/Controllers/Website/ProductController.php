<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('website.products.index', [
            'products' => Product::query()->published()->latest()->paginate(12),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->status === Product::STATUS_PUBLISHED, 404);

        return view('website.products.show', ['product' => $product]);
    }
}
