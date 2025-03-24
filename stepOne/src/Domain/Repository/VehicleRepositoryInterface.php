<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function findByLicensePlate(string $licensePlate): ?Vehicle;

    public function save(Vehicle $vehicle): void;
}
