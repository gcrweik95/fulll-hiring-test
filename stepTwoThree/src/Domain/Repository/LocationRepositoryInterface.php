<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

interface LocationRepositoryInterface
{
    public function findByLatLngVehicle(float $lat, float $lng, Vehicle $vehicle) : ?Location;

    public function save(Location $location) : void;
}
