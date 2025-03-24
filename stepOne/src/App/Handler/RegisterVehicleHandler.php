<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Model\Vehicle;
use Fulll\Domain\Service\VehicleService;
use Fulll\Infra\Persistence\InMemoryFleetRepository;
use Fulll\Infra\Persistence\InMemoryLocationRepository;
use Fulll\Infra\Persistence\InMemoryVehicleRepository;

class RegisterVehicleHandler
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

    public function handle(RegisterVehicleCommand $command): Vehicle
    {
        $vehicle = $this->vehicleService->registerVehicle($command->getFleetId(), $command->getVehicleLicensePlate());
        return $vehicle;
    }
}
