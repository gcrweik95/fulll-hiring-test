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
        return $this->fleetId;
    }
}
