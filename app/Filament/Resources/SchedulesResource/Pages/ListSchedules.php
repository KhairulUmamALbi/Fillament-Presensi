<?php

namespace App\Filament\Resources\SchedulesResource\Pages;

use App\Filament\Resources\SchedulesResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListSchedules extends ListRecords
{
    protected static string $resource = SchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Presensi')
                ->url(route('presensi'))
                ->color('warning'),
            Actions\CreateAction::make(),
        ];
    }
}
