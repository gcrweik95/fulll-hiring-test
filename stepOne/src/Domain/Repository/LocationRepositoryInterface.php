<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Model\Location;
use Fulll\Domain\Model\Vehicle;

interface LocationRepositoryInterface
{
    public function findByLatLngVehicle(float $lat, float $lng, Vehicle $vehicle): ?Location;

    public function save(Location $location): void;
}
