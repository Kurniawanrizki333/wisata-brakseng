<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Kunci Setting')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('value_type')
                    ->label('Jenis Nilai')
                    ->options([
                        'text' => 'Teks',
                        'image' => 'Gambar',
                        'file' => 'File',
                    ])
                    ->default('text')
                    ->required()
                    ->live(),
                Textarea::make('value_text')
                    ->label('Nilai')
                    ->rows(5)
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('value_type') === 'text')
                    ->required(fn (Get $get): bool => $get('value_type') === 'text'),
                FileUpload::make('value_file')
                    ->label('Nilai File')
                    ->directory('settings')
                    ->disk('public')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => in_array($get('value_type'), ['image', 'file'], true))
                    ->required(fn (Get $get): bool => in_array($get('value_type'), ['image', 'file'], true))
                    ->acceptedFileTypes(fn (Get $get): array => $get('value_type') === 'image'
                        ? ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']
                        : ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf'])
                    ->helperText('Upload gambar untuk hero background, QRIS, atau file lain sesuai kebutuhan setting.'),
                Toggle::make('autoload')
                    ->label('Muat Otomatis')
                    ->required(),
            ]);
    }
}
