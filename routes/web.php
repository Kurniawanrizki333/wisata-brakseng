<?php

use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\DestinationController;
use App\Http\Controllers\Website\EventController;
use App\Http\Controllers\Website\GalleryController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\MapController;
use App\Http\Controllers\Website\PaymentController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\ReservationController;
use App\Http\Controllers\Website\TourPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::resource('destinasi', DestinationController::class)->only(['index', 'show'])->parameters([
    'destinasi' => 'destination',
]);

Route::resource('paket-wisata', TourPackageController::class)->only(['index', 'show'])->parameters([
    'paket-wisata' => 'tourPackage',
]);

Route::get('reservasi', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('reservasi', [ReservationController::class, 'store'])->name('reservations.store');

Route::get('pembayaran/{token}', [PaymentController::class, 'show'])->name('pembayaran.show');
Route::post('pembayaran/{token}', [PaymentController::class, 'store'])->name('pembayaran.store');

Route::get('peta-wisata', MapController::class)->name('map');

Route::resource('event', EventController::class)->only(['index', 'show']);
Route::resource('galeri', GalleryController::class)->only(['index']);
Route::resource('produk', ProductController::class)->only(['index', 'show'])->parameters([
    'produk' => 'product',
]);

Route::get('kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('kontak', [ContactController::class, 'store'])->name('contact.store');
