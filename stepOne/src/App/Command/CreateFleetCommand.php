<?php

namespace Fulll\App\Command;

class CreateFleetCommand
{
    private string $fleetId;
    // This is a test
    public function __construct(string $fleetId)
    {
        $this->fleetId = $fleetId;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }
}
