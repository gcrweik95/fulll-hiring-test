<?php

namespace Fulll\App\Command;

class ParkVehicleCommand
{
    private string $fleetId;
    private string $vehicleLicensePlate;
    private float $lat;
    private float $lng;

    public function __construct(
        string $fleetId,
        string $vehicleLicensePlate,
        float $lat,
        float $lng
    ) {
        $this->fleetId = $fleetId;
        $this->vehicleLicensePlate = $vehicleLicensePlate;
        $this->lng = $lat;
        $this->lng = $lng;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function getVehicleLicensePlate(): string
    {
        return $this->vehicleLicensePlate;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }
}
