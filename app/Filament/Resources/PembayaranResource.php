<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Filament\Resources\PembayaranResource\RelationManagers;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('diagnosa_id')
                    ->relationship('diagnosa', 'rekam_medis')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_masuk')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_keluar')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('diagnosa.rekam_medis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('diagnosa.pasien_id')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('diagnosa.kamar_id')
                    ->label('No Kamar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga_kamar')
                    ->label('Total Harga Kamar')
                    ->getStateUsing(function ($record) {
                        return 'Rp. ' . number_format($record->calculateTotalHargaKamar(), 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('total_diagnosa')
                    ->label('Total Diagnosa')
                    ->getStateUsing(function ($record) {
                        return 'Rp. ' . number_format($record->calculateTotalDiagnosa(), 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->getStateUsing(function ($record) {
                        return 'Rp. ' . number_format($record->calculateTotal(), 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}