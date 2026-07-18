<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['value'] = $this->resolveSettingValue($data);

        unset($data['value_text'], $data['value_file']);

        return $data;
    }

    private function resolveSettingValue(array $data): ?string
    {
        return match ($data['value_type'] ?? 'text') {
            'image', 'file' => $data['value_file'] ?? null,
            default => $data['value_text'] ?? null,
        };
    }
}
