<?php

declare(strict_types=1);

namespace App\App\Handler;

use App\App\Command\RegisterVehicleCommand;
use App\Domain\Model\Vehicle;
use App\Domain\Service\VehicleService;

class RegisterVehicleHandler
{
    public function __construct(
        private readonly VehicleService $vehicleService,
    ) {
    }

    public function handle(RegisterVehicleCommand $command) : Vehicle
    {
        $vehicle = $this->vehicleService->registerVehicle($command->getFleetId(), $command->getVehicleLicensePlate());

        return $vehicle;
    }
}
