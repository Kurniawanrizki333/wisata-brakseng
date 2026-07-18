<?php

namespace App\Filament\Resources\Reservations\Schemas;

use App\Models\Reservation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reservation_code')
                    ->label('Kode Pemesanan')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Dibuat otomatis saat menyimpan'),
                TextInput::make('nomor_invoice')
                    ->label('Nomor Invoice')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Dibuat otomatis saat menyimpan'),
                Select::make('tour_package_id')
                    ->label('Paket Wisata')
                    ->relationship('tourPackage', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('visitor_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Nomor Telepon / WhatsApp')
                    ->tel()
                    ->required(),
                DatePicker::make('reservation_date')
                    ->label('Tanggal Reservasi')
                    ->required(),
                TextInput::make('total_people')
                    ->label('Jumlah Peserta')
                    ->required()
                    ->numeric(),
                TextInput::make('total_price')
                    ->label('Total Tagihan')
                    ->numeric()
                    ->prefix('Rp'),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->required()
                    ->options(Reservation::paymentMethodOptions())
                    ->default('bank_transfer'),
                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->required()
                    ->options(Reservation::paymentStatusOptions())
                    ->default(Reservation::PEMBAYARAN_BELUM_DIBAYAR),
                Select::make('status')
                    ->label('Status Reservasi')
                    ->required()
                    ->options(Reservation::statusOptions())
                    ->default(Reservation::STATUS_MENUNGGU_PEMBAYARAN),
                FileUpload::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->disk('public')
                    ->directory('bukti-pembayaran')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                    ->maxSize(4096)
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
                Textarea::make('catatan_pembayaran')
                    ->label('Catatan Pembayaran')
                    ->columnSpanFull(),
                Textarea::make('alasan_penolakan')
                    ->label('Alasan Penolakan')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->label('Catatan Reservasi')
                    ->columnSpanFull(),
            ]);
    }
}
