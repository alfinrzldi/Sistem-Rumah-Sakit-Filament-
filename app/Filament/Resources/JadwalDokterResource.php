<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalDokterResource\Pages;
use App\Filament\Resources\JadwalDokterResource\RelationManagers;
use App\Models\JadwalDokter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalDokterResource extends Resource
{
    protected static ?string $model = JadwalDokter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Jadwal Dokter';

    protected static ?string $navigationGroup = 'Data Manajemen Rumah Sakit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Masukkan Data Jadwal Dokter')
                    ->schema([
                        Forms\Components\Select::make('dokter_id')
                            ->relationship('dokter', 'nama')
                            ->required(),
                        Forms\Components\Select::make('hari')
                            ->label('Hari')
                            ->required()
                            ->options([
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jum`at' => "Jum'at",
                                'Sabtu' => 'Sabtu',
                                'Minggu' => 'Minggu',
                            ]),
                        Forms\Components\Select::make('jam')
                            ->required()
                            ->options([
                                '07:00-08:00' => '07:00-08:00',
                                '08:00-09:00' => '08:00-09:00',
                                '09:00-10:00' => '09:00-10:00',
                                '10:00-11:00' => '10:00-11:00',
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hari')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jam')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('dokter_id')
                    ->label('Dokter')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->dokter->nama;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalDokters::route('/'),
            'create' => Pages\CreateJadwalDokter::route('/create'),
            'edit' => Pages\EditJadwalDokter::route('/{record}/edit'),
        ];
    }
}