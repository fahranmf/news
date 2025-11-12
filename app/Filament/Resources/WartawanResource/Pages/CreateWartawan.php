<?php

namespace App\Filament\Resources\WartawanResource\Pages;

use App\Filament\Resources\WartawanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWartawan extends CreateRecord
{
    protected static string $resource = WartawanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
