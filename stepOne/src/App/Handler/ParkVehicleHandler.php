<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Domain\Model\Location;
use Fulll\Domain\Service\VehicleService;
use Fulll\Infra\Persistence\InMemoryFleetRepository;
use Fulll\Infra\Persistence\InMemoryLocationRepository;
use Fulll\Infra\Persistence\InMemoryVehicleRepository;

class ParkVehicleHandler
{
    private VehicleService $vehicleService;

    private InMemoryFleetRepository $fleetRepository;
    private InMemoryVehicleRepository $vehicleRepository;
    private InMemoryLocationRepository $locationRepository;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->vehicleRepository = new InMemoryVehicleRepository();
        $this->locationRepository = new InMemoryLocationRepository();

        $this->vehicleService = new VehicleService($this->fleetRepository, $this->vehicleRepository, $this->locationRepository);
    }

    public function handle(ParkVehicleCommand $command): Location
    {
        $location = $this->vehicleService->parkVehicle($command->getFleetId(), $command->getVehicleLicensePlate(), $command->getLat(), $command->getLng());
        return $location;
    }
}
