<?php

namespace App\Filament\Resources\Reservations\Schemas;

use App\Models\Reservation;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReservationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('reservation_code')
                    ->label('Kode Pemesanan')
                    ->copyable()
                    ->placeholder('-'),
                TextEntry::make('nomor_invoice')
                    ->label('Nomor Invoice')
                    ->copyable()
                    ->placeholder('-'),
                TextEntry::make('tourPackage.name')
                    ->label('Paket Wisata')
                    ->placeholder('-'),
                TextEntry::make('visitor_name')
                    ->label('Nama Pelanggan'),
                TextEntry::make('email')
                    ->label('Email'),
                TextEntry::make('phone')
                    ->label('Nomor Telepon / WhatsApp'),
                TextEntry::make('reservation_date')
                    ->label('Tanggal Reservasi')
                    ->date(),
                TextEntry::make('total_people')
                    ->label('Jumlah Peserta')
                    ->numeric(),
                TextEntry::make('total_price')
                    ->label('Total Tagihan')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextEntry::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(fn (Reservation $record): string => $record->namaMetodePembayaran()),
                TextEntry::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Reservation::PEMBAYARAN_SUDAH_DIBAYAR => 'success',
                        Reservation::PEMBAYARAN_DITOLAK => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (Reservation $record): string => $record->nama_status_pembayaran),
                TextEntry::make('status')
                    ->label('Status Reservasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Reservation::STATUS_PEMBAYARAN_DISETUJUI => 'info',
                        Reservation::STATUS_SELESAI => 'success',
                        Reservation::STATUS_PEMBAYARAN_DITOLAK, Reservation::STATUS_DIBATALKAN => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (Reservation $record): string => $record->nama_status),
                TextEntry::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->placeholder('-')
                    ->url(fn (Reservation $record): ?string => $record->bukti_pembayaran_url, shouldOpenInNewTab: true)
                    ->formatStateUsing(fn (?string $state): string => $state ? 'Lihat Bukti Pembayaran' : '-'),
                TextEntry::make('tanggal_upload_bukti')
                    ->label('Tanggal Upload Bukti')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('catatan_pembayaran')
                    ->label('Catatan Pembayaran')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('verifikator.name')
                    ->label('Diverifikasi Oleh')
                    ->placeholder('-'),
                TextEntry::make('tanggal_verifikasi_pembayaran')
                    ->label('Tanggal Verifikasi Pembayaran')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('alasan_penolakan')
                    ->label('Alasan Penolakan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('nomor_kwitansi')
                    ->label('Nomor Kwitansi')
                    ->copyable()
                    ->placeholder('-'),
                TextEntry::make('tanggal_invoice_dikirim')
                    ->label('Tanggal Invoice Dikirim')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('tanggal_kwitansi_dikirim')
                    ->label('Tanggal Kwitansi Dikirim')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->label('Catatan Reservasi')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label('Dihapus Pada')
                    ->dateTime()
                    ->visible(fn (Reservation $record): bool => $record->trashed()),
            ]);
    }
}
