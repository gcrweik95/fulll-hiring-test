<?php

namespace Fulll\Infra\Persistence;

use Fulll\Domain\Model\Location;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Repository\LocationRepositoryInterface;

class InMemoryLocationRepository implements LocationRepositoryInterface
{
    private array $locations = [];

    public function save(Location $location): void
    {
        $this->locations[$location->getLat() . "-" . $location->getLng()] = $location;
    }

    public function findByLatLngVehicle(float $lat, float $lng, Vehicle $vehicle): ?Location
    {
        $location = $this->locations[$lat . "-" . $lng];
        if ($location) {
            if ($location->getVehicle() === $vehicle) {
                return $location;
            }
        }
        return null;
    }

    public function reset(): void
    {
        $this->locations = [];
    }
}
