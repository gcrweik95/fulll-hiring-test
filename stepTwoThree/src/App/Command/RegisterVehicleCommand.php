<?php

declare(strict_types=1);

namespace App\App\Command;

class RegisterVehicleCommand
{
    public function __construct(
        private readonly string $fleetId,
        private readonly string $vehicleLicensePlate,
    ) {
    }

    public function getFleetId() : string
    {
        return $this->fleetId;
    }

    public function getVehicleLicensePlate() : string
    {
        return $this->vehicleLicensePlate;
    }
}
