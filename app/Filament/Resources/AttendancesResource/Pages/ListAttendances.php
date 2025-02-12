<?php

namespace App\Filament\Resources\AttendancesResource\Pages;

use App\Filament\Resources\AttendancesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendancesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Export')
            ->url(route('export-attendance'))
            ->color('danger'),

            Action::make('Tambah Presensi')
            ->url(route('presensi'))
            ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}
