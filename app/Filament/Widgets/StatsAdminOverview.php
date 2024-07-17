<?php

namespace App\Filament\Widgets;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Petugas;
use App\Models\Kamar;
use App\Models\Diagnosa;
use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('jumlah_dokter', Dokter::query()->count())
                ->label('Jumlah Dokter')
                ->description('Total Dokter yang Tersedia')
                // ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('jumlah_pasien', Pasien::query()->count())
                ->label('Jumlah Pasien')
                ->description('Total Pasien Terdaftar')
                // ->descriptionIcon('heroicon-o-users')
                ->color('info'),

            Stat::make('jumlah_petugas', Petugas::query()->count())
                ->label('Jumlah Petugas')
                ->description('Total Petugas yang Tersedia')
                // ->descriptionIcon('heroicon-o-briefcase')
                ->color('warning'),

            Stat::make('jumlah_kamar', Kamar::query()->count())
                ->label('Jumlah Kamar')
                ->description('Total Kamar yang Tersedia')
                // ->descriptionIcon('heroicon-o-office-building')
                ->color('success'),

            Stat::make('jumlah_diagnosa', Diagnosa::query()->count())
                ->label('Jumlah Diagnosa')
                ->description('Total Diagnosa yang Tercatat')
                // ->descriptionIcon('heroicon-o-document-text')
                ->color('info'),

            Stat::make('jumlah_pembayaran', Pembayaran::query()->count())
                ->label('Jumlah Pembayaran')
                ->description('Total Pembayaran yang Terdata')
                // ->descriptionIcon('heroicon-o-cash')
                ->color('warning'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}