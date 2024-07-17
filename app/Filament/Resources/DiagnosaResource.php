<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiagnosaResource\Pages;
use App\Filament\Resources\DiagnosaResource\RelationManagers;
use App\Models\Diagnosa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiagnosaResource extends Resource
{
    protected static ?string $model = Diagnosa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Diagnosa';

    protected static ?string $modelLabel = 'Diagnosa';

    protected static ?string $navigationGroup = 'Administrasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Masukkan Nomor Rekam Medis')
                    ->schema([
                        Forms\Components\TextInput::make('rekam_medis')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\Section::make('Masukkan Petugas dan Pasien')
                    ->schema([
                        Forms\Components\Select::make('dokter_id')
                            ->relationship('dokter', 'nama')
                            ->required(),
                        Forms\Components\Select::make('pasien_id')
                            ->relationship('pasien', 'nama')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Masukkan Diagnosa Pasien')
                    ->schema([
                        Forms\Components\TextInput::make('penyakit')
                            ->required(),
                        Forms\Components\Select::make('kamar_id')
                            ->relationship('kamar', 'no_kamar')
                        ,
                        Forms\Components\TextInput::make('harga')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rekam_medis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dokter.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pasien.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penyakit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kamar.no_kamar')
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
            'index' => Pages\ListDiagnosas::route('/'),
            'create' => Pages\CreateDiagnosa::route('/create'),
            'edit' => Pages\EditDiagnosa::route('/{record}/edit'),
        ];
    }
}