<?php

use App\Livewire\Presensi;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendancesExport;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

Route::group(['middleware' => 'auth'], function () {
    route::get('presensi', Presensi::class)->name('presensi');
    route::get('attendace/export', function(){
        return Excel::download(new AttendancesExport, 'attendances.xlsx');
    })->name('export-attendance');
});
