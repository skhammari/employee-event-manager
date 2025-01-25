<?php

namespace App\Filament\Resources\EventParticipationResource\Pages;

use App\Filament\Resources\EventParticipationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventParticipations extends ListRecords
{
    protected static string $resource = EventParticipationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
