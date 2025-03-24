<?php

declare(strict_types=1);

namespace App\App\Handler;

use App\App\Command\ParkVehicleCommand;
use App\Domain\Model\Location;
use App\Domain\Service\VehicleService;

class ParkVehicleHandler
{
    public function __construct(
        private readonly VehicleService $vehicleService,
    ) {
    }

    public function handle(ParkVehicleCommand $command) : Location
    {
        $location = $this->vehicleService->parkVehicle($command->getFleetId(), $command->getVehicleLicensePlate(), $command->getLat(), $command->getLng());

        return $location;
    }
}
