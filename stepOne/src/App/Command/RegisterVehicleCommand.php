<?php

namespace Fulll\App\Command;

class RegisterVehicleCommand
{
    private string $fleetId;
    private string $vehicleLicensePlate;

    public function __construct(string $fleetId, string $vehicleLicensePlate)
    {
        $this->fleetId = $fleetId;
        $this->vehicleLicensePlate = $vehicleLicensePlate;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function getVehicleLicensePlate(): string
    {
        return $this->vehicleLicensePlate;
    }
}
