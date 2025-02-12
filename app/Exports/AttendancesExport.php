<?php

namespace App\Exports;
use App\Models\Attendances;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\Schema;


class AttendancesExport implements WithHeadings, FromQuery
{

    public function query()
    {
        return Attendances::query()
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->select([
                'users.email',
                'users.name as username',
                'users.created_at',
                'attendances.schedule_latitude',
                'attendances.schedule_longitude',
                'attendances.schedule_start_time',
                'attendances.schedule_end_time',
                'attendances.start_latitude',
                'attendances.start_longitude',
                'attendances.start_time',
                'attendances.end_time',
                'attendances.end_latitude',
                'attendances.end_longitude',
            ]);
    }

    public function headings(): array
    {
        return [
            'Email',
            'Username',
            'User Created At',
            'Schedule Latitude',
            'Schedule Longitude',
            'Schedule Start Time',
            'Schedule End Time',
            'Schedule Start Latitude',
            'Schedule Start Longitude',
            'Start Time',
            'End Time',
            'End Latitude',
            'End Longitude',
        ];
    }

}
