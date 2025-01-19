<?php

namespace App\Filament\Resources\OfficesResource\Pages;

use App\Filament\Resources\OfficesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOffices extends EditRecord
{
    protected static string $resource = OfficesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
