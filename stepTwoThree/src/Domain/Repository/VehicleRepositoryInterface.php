<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function findByLicensePlate(string $licensePlate) : ?Vehicle;

    public function save(Vehicle $vehicle) : void;
}
