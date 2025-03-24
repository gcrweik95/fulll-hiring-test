<?php

declare(strict_types=1);

namespace App\App\Command;

class CreateFleetCommand
{
    public function __construct(private readonly string $fleetId)
    {
    }

    public function getFleetId() : string
    {
        // This is a test 4
        return $this->fleetId;
    }
}
