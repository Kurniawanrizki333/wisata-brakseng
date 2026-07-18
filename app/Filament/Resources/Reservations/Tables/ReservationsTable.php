<?php

namespace App\Filament\Resources\Reservations\Tables;

use App\Models\Reservation;
use App\Services\ReservationNotificationService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ReservationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([
                TextColumn::make('reservation_code')
                    ->label('Kode Pemesanan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_invoice')
                    ->label('Nomor Invoice')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('tourPackage.name')
                    ->label('Paket Wisata')
                    ->searchable(),
                TextColumn::make('visitor_name')
                    ->label('Nama Pelanggan')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->searchable(),
                TextColumn::make('reservation_date')
                    ->label('Tanggal Reservasi')
                    ->date()
                    ->sortable(),
                TextColumn::make('total_people')
                    ->label('Jumlah Peserta')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total Tagihan')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        Reservation::PEMBAYARAN_SUDAH_DIBAYAR => 'success',
                        Reservation::PEMBAYARAN_DITOLAK => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn(Reservation $record): string => $record->nama_status_pembayaran)
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status Reservasi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        Reservation::STATUS_PEMBAYARAN_DISETUJUI => 'info',
                        Reservation::STATUS_SELESAI => 'success',
                        Reservation::STATUS_PEMBAYARAN_DITOLAK, Reservation::STATUS_DIBATALKAN => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn(Reservation $record): string => $record->nama_status)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Dihapus Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Reservasi')
                    ->options(Reservation::statusOptions()),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat'),
                Action::make('invoice')
                    ->label('Lihat Invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('gray')
                    ->modalContent(fn(Reservation $record) => view('components.invoice-modal', ['reservation' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                Action::make('bukti_pembayaran')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('gray')
                    ->url(fn(Reservation $record): ?string => $record->bukti_pembayaran_url)
                    ->openUrlInNewTab()
                    ->visible(fn(Reservation $record): bool => filled($record->bukti_pembayaran)),
                Action::make('setujui_pembayaran')
                    ->label('Setujui Pembayaran')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Reservation $record): bool => $record->payment_status === Reservation::PEMBAYARAN_MENUNGGU_VERIFIKASI)
                    ->action(function (Reservation $record): void {
                        $record->update([
                            'status' => Reservation::STATUS_PEMBAYARAN_DISETUJUI,
                            'payment_status' => Reservation::PEMBAYARAN_SUDAH_DIBAYAR,
                            'diverifikasi_oleh' => auth()->id(),
                            'tanggal_verifikasi_pembayaran' => now(),
                            'alasan_penolakan' => null,
                        ]);

                        app(ReservationNotificationService::class)->kirimKwitansi($record->refresh());

                        Notification::make()
                            ->title('Pembayaran disetujui dan kwitansi dikirim.')
                            ->success()
                            ->send();
                    }),
                Action::make('tolak_pembayaran')
                    ->label('Tolak Pembayaran')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(Reservation $record): bool => $record->payment_status === Reservation::PEMBAYARAN_MENUNGGU_VERIFIKASI)
                    ->form([
                        Textarea::make('alasan_penolakan')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->maxLength(1000),
                    ])
                    ->action(function (Reservation $record, array $data): void {
                        $record->update([
                            'status' => Reservation::STATUS_PEMBAYARAN_DITOLAK,
                            'payment_status' => Reservation::PEMBAYARAN_DITOLAK,
                            'diverifikasi_oleh' => auth()->id(),
                            'tanggal_verifikasi_pembayaran' => now(),
                            'alasan_penolakan' => $data['alasan_penolakan'],
                        ]);

                        app(ReservationNotificationService::class)->kirimPenolakan($record->refresh());

                        Notification::make()
                            ->title('Pembayaran ditolak dan email penolakan dikirim.')
                            ->danger()
                            ->send();
                    }),
                Action::make('selesai')
                    ->label('Tandai Selesai')
                    ->color('success')
                    ->visible(fn(Reservation $record): bool => $record->status === Reservation::STATUS_PEMBAYARAN_DISETUJUI)
                    ->action(fn(Reservation $record) => $record->update(['status' => Reservation::STATUS_SELESAI])),
                Action::make('batalkan')
                    ->label('Batalkan')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(Reservation $record): bool => !in_array($record->status, [Reservation::STATUS_SELESAI, Reservation::STATUS_DIBATALKAN], true))
                    ->action(fn(Reservation $record) => $record->update(['status' => Reservation::STATUS_DIBATALKAN])),
                EditAction::make()
                    ->label('Ubah'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
