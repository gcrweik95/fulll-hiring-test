<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;

class Vehicle
{
    private string $licensePlate;
    private ?Location $location = null;
    private ?Fleet $fleet = null;

    public function __construct(string $licensePlate)
    {
        $this->licensePlate = $licensePlate;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    public function setLocation(Location $location): void
    {
        if ($this->location !== null && $this->location->equals($location)) {
            throw new VehicleAlreadyParkedAtLocationException();
        }
        $this->location = $location;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setFleet(Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }
}
