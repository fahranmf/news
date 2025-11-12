<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KomentarResource\Pages;
use App\Models\Komentar;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KomentarResource extends Resource
{
    protected static ?string $model = Komentar::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Komentar';
    //protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('news.judul')
                    ->label('Judul Berita')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Komentator')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('isi')
                    ->label('Isi Komentar')
                    ->limit(50)
                    ->wrap()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomentars::route('/'),
        ];
    }
}
