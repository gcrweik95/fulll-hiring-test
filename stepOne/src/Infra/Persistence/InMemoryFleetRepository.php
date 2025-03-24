<?php

namespace Fulll\Infra\Persistence;

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Repository\FleetRepositoryInterface;

class InMemoryFleetRepository implements FleetRepositoryInterface
{
    private array $fleets = [];

    public function save(Fleet $fleet): void
    {
        $this->fleets[$fleet->getId()] = $fleet;
    }

    public function findById(string $fleetId): ?Fleet
    {
        return $this->fleets[$fleetId] ?? null;
    }

    public function findByFleetAndVehicle(Fleet $fleet, Vehicle $vehicle): bool
    {
        $fleet = $this->fleets[$fleet->getId()];
        if ($fleet) {
            $vehicles = $fleet->getVehicles();
            return isset($vehicles[$vehicle->getLicensePlate()]);
        }
        return false;
    }

    public function reset(): void
    {
        $this->fleets = [];
    }
}
