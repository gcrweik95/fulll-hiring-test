<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Exception\FleetAlreadyExistsException;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Infra\Persistence\FleetRepository;

class FleetService
{
    public function __construct(
        private readonly FleetRepository $fleetRepository,
    ) {
    }

    public function create(string $fleetId) : Fleet
    {
        $fleet = $this->fleetRepository->findById($fleetId);
        if ($fleet) {
            throw new FleetAlreadyExistsException();
        }

        $fleet = new Fleet();
        $fleet->setFleetId($fleetId);

        $this->fleetRepository->save($fleet);

        return $fleet;
    }

    public function fleetHasVehicle(Fleet $aFleet, Vehicle $aVehicle) : bool
    {
        return $aFleet->hasVehicle($aVehicle);
    }
}
