<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\Diagnosa;
use App\Models\Kamar;
use App\Models\Obat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static ?string $navigationGroup = 'Administrasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Nomor Rekam Medis')
                    ->schema([
                        Forms\Components\Select::make('diagnosa_id')
                            ->relationship('diagnosa', 'rekam_medis')
                            ->required()
                            ->label('Nomor Rekam Medis')
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set, $state) => self::updateFieldsBasedOnDiagnosa($set, $state)),
                        Forms\Components\Select::make('pasien_id')
                            ->relationship('pasien', 'nama')
                            ->required(),
                        Forms\Components\Select::make('kamar_id')
                            ->relationship('kamar', 'no_kamar')
                            ->required(),
                        Forms\Components\Select::make('obat_id')
                            ->relationship('obat', 'nama')
                            ->required(),
                        Forms\Components\TextInput::make('jumlah_obat')
                            ->required()
                            ->numeric()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set, $state, $get) => self::calculateTotal($set, $get)),
                        Forms\Components\TextInput::make('harga')
                            ->label('Harga Perawatan')
                            ->required()
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set, $state, $get) => self::calculateTotal($set, $get)),
                        Forms\Components\TextInput::make('total_biaya')
                            ->label('Total Biaya')
                            ->disabled()
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set, $state) => $set('jumlah', $state)),
                        Forms\Components\Hidden::make('jumlah')
                            ->label('Total Biaya (Jumlah)')
                            ->required()
                            ->dehydrateStateUsing(fn ($state, $get) => $get('total_biaya')),
                    ]),
                Forms\Components\Section::make('Tanggal')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->required(),
                    ])
            ]);
    }

    public static function updateFieldsBasedOnDiagnosa(callable $set, $diagnosaId)
    {
        $diagnosa = Diagnosa::with(['pasien', 'kamar', 'obats'])->find($diagnosaId);

        if ($diagnosa) {
            $set('pasien_id', $diagnosa->pasien_id);
            $set('kamar_id', $diagnosa->kamar_id);

            $firstObat = $diagnosa->obats->first();
            if ($firstObat) {
                $set('obat_id', $firstObat->id);
            }

            $hargaPerawatan = $diagnosa->harga;
            $set('harga', $hargaPerawatan);
        }
    }

    public static function calculateTotal(callable $set, callable $get)
    {
        $kamar = Kamar::find($get('kamar_id'));
        $obat = Obat::find($get('obat_id'));
        $jumlahObat = $get('jumlah_obat');
        $hargaPerawatan = $get('harga');

        $hargaKamar = $kamar ? $kamar->harga : 0;
        $hargaObat = $obat ? $obat->harga : 0;

        $totalBiaya = $hargaKamar + ($hargaObat * $jumlahObat) + $hargaPerawatan;

        $set('total_biaya', $totalBiaya);
        $set('jumlah', $totalBiaya); // Set jumlah to total_biaya
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('diagnosa_id')
                    ->label('Nomor Rekam Medis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pasien_id')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->pasien->nama;   
                    }),
                    Tables\Columns\TextColumn::make('obat_id')
                    ->label('Nama Obat')
                    ->searchable(),
                    // ->getStateUsing(function ($record) {
                    //     return $record->obat->nama;   
                    // }),
                Tables\Columns\TextColumn::make('kamar_id')
                    ->label('Nomor Kamar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_obat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga Perawatan')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return ' Rp. ' . number_format($record->harga, 0, ',', '.');   
                    }),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Total Biaya')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return ' Rp. ' . number_format($record->jumlah, 0, ',', '.');   
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
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
