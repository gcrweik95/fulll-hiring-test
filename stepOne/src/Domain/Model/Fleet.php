<?php

namespace Fulll\Domain\Model;

use Fulll\Domain\Exception\VehicleAlreadyRegisteredException;
use Fulll\Domain\Exception\VehicleNotFoundInFleetException;

class Fleet
{
    private string $id;
    /** @var Vehicle[] */
    private array $vehicles = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        if ($this->hasVehicle($vehicle)) {
            throw new VehicleAlreadyRegisteredException();
        }
        $this->vehicles[] = $vehicle;
    }

    public function removeVehicle(Vehicle $vehicle): void
    {
        if (!$this->hasVehicle($vehicle)) {
            throw new VehicleNotFoundInFleetException();
        }
        $this->vehicles = array_filter($this->vehicles, function (Vehicle $v) use ($vehicle) {
            return $v !== $vehicle;
        });
    }

    public function hasVehicle(Vehicle $vehicle): bool
    {
        foreach ($this->vehicles as $v) {
            if ($v->getLicensePlate() === $vehicle->getLicensePlate()) {
                return true;
            }
        }
        return false;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }
}
