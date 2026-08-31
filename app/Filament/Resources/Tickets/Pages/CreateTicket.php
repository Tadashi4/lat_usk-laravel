<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use Filament\Resources\Pages\CreateRecord;

use function Livewire\str;
use function Symfony\Component\Clock\now;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function mutateFormaDataBeforeCreate(array $data): array
    {
        
    $data['ticket_number'] = 'REQ' . now()->format('Ymd') . '-' . strtoupper(str()->random(4));
    return $data;
    }
}
