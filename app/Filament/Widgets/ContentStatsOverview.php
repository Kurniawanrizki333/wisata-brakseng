<?php

namespace App\Filament\Widgets;

use App\Models\Destination;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\TourPackage;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Destinasi', Destination::query()->count())
                ->icon(Heroicon::OutlinedMapPin)
                ->color('success'),
            Stat::make('Total Paket', TourPackage::query()->count())
                ->icon(Heroicon::OutlinedTicket)
                ->color('info'),
            Stat::make('Total Reservasi', Reservation::query()->count())
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color('warning'),
            Stat::make('Total Event', Event::query()->count())
                ->icon(Heroicon::OutlinedCalendarDays)
                ->color('primary'),
            Stat::make('Total Produk', Product::query()->count())
                ->icon(Heroicon::OutlinedShoppingBag)
                ->color('danger'),
            Stat::make('Total Galeri', Gallery::query()->count())
                ->icon(Heroicon::OutlinedPhoto)
                ->color('gray'),
        ];
    }
}
