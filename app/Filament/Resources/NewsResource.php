<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NewsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsResource\RelationManagers;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Berita')
                    ->schema([
                        Select::make('wartawan_id')
                            ->label('Wartawan')
                            ->relationship('wartawan', 'nama')
                            ->preload()
                            ->required(),
                        TextInput::make('judul')
                            ->label('Judul Berita')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('ringkasan')
                            ->label('Ringkasan')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('isi')
                            ->label('Isi Berita')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wartawan.nama')->label('Nama Wartawan')->searchable()->sortable(),
                TextColumn::make('judul')->label('Judul Berita')->searchable()->sortable(),
                TextColumn::make('ringkasan')->label('Ringkasan')->limit(50)->sortable(),
                TextColumn::make('isi')->label('Isi Berita')->limit(50)->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
