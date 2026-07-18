<?php

namespace App\Filament\Resources\Reservations\Pages;

use App\Filament\Resources\Reservations\ReservationResource;
use App\Models\Reservation;
use App\Services\ReservationNotificationService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewReservation extends ViewRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('invoice')
                ->label('Lihat Invoice')
                ->icon('heroicon-o-document-text')
                ->color('gray')
                ->modalContent(fn () => view('components.invoice-modal', ['reservation' => $this->getRecord()]))
                ->modalSubmitAction(false)
                ->modalCancelAction(false),
            Action::make('bukti_pembayaran')
                ->label('Lihat Bukti Pembayaran')
                ->icon('heroicon-o-photo')
                ->color('gray')
                ->url(fn (): ?string => $this->getRecord()->bukti_pembayaran_url)
                ->openUrlInNewTab()
                ->visible(fn (): bool => filled($this->getRecord()->bukti_pembayaran)),
            Action::make('setujui_pembayaran')
                ->label('Setujui Pembayaran')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (): bool => $this->getRecord()->payment_status === Reservation::PEMBAYARAN_MENUNGGU_VERIFIKASI)
                ->action(function (): void {
                    $record = $this->getRecord();
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
                ->visible(fn (): bool => $this->getRecord()->payment_status === Reservation::PEMBAYARAN_MENUNGGU_VERIFIKASI)
                ->form([
                    Textarea::make('alasan_penolakan')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->maxLength(1000),
                ])
                ->action(function (array $data): void {
                    $record = $this->getRecord();
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
            EditAction::make()
                ->label('Ubah'),
        ];
    }
}
