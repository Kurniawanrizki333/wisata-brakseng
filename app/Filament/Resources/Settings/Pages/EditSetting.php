<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['value_text'] = $data['value_type'] === 'text' ? $data['value'] : null;
        $data['value_file'] = in_array($data['value_type'], ['image', 'file'], true) ? $data['value'] : null;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['value'] = match ($data['value_type'] ?? 'text') {
            'image', 'file' => $data['value_file'] ?? $this->getRecord()->value,
            default => $data['value_text'] ?? $this->getRecord()->value,
        };

        unset($data['value_text'], $data['value_file']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
