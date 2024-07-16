<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KamarResource\Pages;
use App\Filament\Resources\KamarResource\RelationManagers;
use App\Models\Kamar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kamar';

    protected static ?string $navigationGroup = 'Data Manajemen Rumah Sakit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Masukkan Data Kamar')
                    ->schema([
                        Forms\Components\TextInput::make('no_kamar')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('pasien_id')
                            ->label('Nomor Pasien')
                            ->relationship('pasien', 'NIK')
                            ->required(),
                        Forms\Components\TextInput::make('harga')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('status')
                            ->label('Status Kamar')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_kamar')
                    ->label('Nomor Kamar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pasien_id')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->pasien ? $record->pasien->nama : '-';
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Kamar')
                    ->getStateUsing(function ($record) {
                        return $record->status ? 'Kamar Terisi' : 'Kamar Kosong';
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        return 'Rp. ' . number_format($record->harga, 0, ',', '.');
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
            'index' => Pages\ListKamars::route('/'),
            'create' => Pages\CreateKamar::route('/create'),
            'edit' => Pages\EditKamar::route('/{record}/edit'),
        ];
    }
}
