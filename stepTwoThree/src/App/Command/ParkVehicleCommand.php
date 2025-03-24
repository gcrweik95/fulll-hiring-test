<?php

declare(strict_types=1);

namespace App\App\Command;

class ParkVehicleCommand
{
    public function __construct(
        public readonly string $fleetId,
        public readonly string $vehicleLicensePlate,
        public readonly float $lat,
        public readonly float $lng,
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

    public function getLat() : float
    {
        return $this->lat;
    }

    public function getLng() : float
    {
        return $this->lng;
    }
}
