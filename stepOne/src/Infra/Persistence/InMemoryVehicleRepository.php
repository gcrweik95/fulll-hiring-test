<?php

namespace Fulll\Infra\Persistence;

use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Repository\VehicleRepositoryInterface;

class InMemoryVehicleRepository implements VehicleRepositoryInterface
{
    private array $vehicles = [];

    public function save(Vehicle $vehicle): void
    {
        $this->vehicles[$vehicle->getLicensePlate()] = $vehicle;
    }

    public function findByLicensePlate(string $licensePlate): ?Vehicle
    {
        return $this->vehicles[$licensePlate] ?? null;
    }

    public function reset(): void
    {
        $this->vehicles = [];
    }
}
