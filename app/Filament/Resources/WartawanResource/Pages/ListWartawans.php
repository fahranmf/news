<?php

namespace App\Filament\Resources\WartawanResource\Pages;

use App\Filament\Resources\WartawanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWartawans extends ListRecords
{
    protected static string $resource = WartawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
