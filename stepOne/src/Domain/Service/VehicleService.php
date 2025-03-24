<?php

namespace Fulll\Domain\Service;

use Fulll\Domain\Exception\FleetNotFoundException;
use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredException;
use Fulll\Domain\Model\Location;
use Fulll\Domain\Model\Vehicle;
use Fulll\Infra\Persistence\InMemoryFleetRepository;
use Fulll\Infra\Persistence\InMemoryLocationRepository;
use Fulll\Infra\Persistence\InMemoryVehicleRepository;

class VehicleService
{
    private InMemoryVehicleRepository $vehicleRepository;
    private InMemoryFleetRepository $fleetRepository;
    private InMemoryLocationRepository $locationRepository;

    public function __construct(InMemoryFleetRepository $fleetRepository, InMemoryVehicleRepository $vehicleRepository, InMemoryLocationRepository $locationRepository)
    {
        $this->fleetRepository = $fleetRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->locationRepository = $locationRepository;
    }

    public function create(string $licensePlate): Vehicle
    {
        $vehicle = $this->vehicleRepository->findByLicensePlate($licensePlate);
        if (!$vehicle) {
            $vehicle = new Vehicle($licensePlate);
            $this->vehicleRepository->save($vehicle);
        }
        return $vehicle;
    }

    public function registerVehicle(string $fleetId, string $licensePlate): Vehicle
    {
        $fleet = $this->fleetRepository->findById($fleetId);
        if (!$fleet) {
            throw new FleetNotFoundException();
        }

        $vehicle = $this->vehicleRepository->findByLicensePlate($licensePlate);
        if (!$vehicle) {
            $vehicle = new Vehicle($licensePlate);
            $this->vehicleRepository->save($vehicle);
        }

        if ($this->fleetRepository->findByFleetAndVehicle($fleet, $vehicle)) {
            throw new VehicleAlreadyRegisteredException();
        }

        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet);

        return $vehicle;
    }

    public function parkVehicle(string $fleetId, string $licensePlate, float $lat, float $lng): Location
    {
        $fleet = $this->fleetRepository->findById($fleetId);
        if (!$fleet) {
            throw new FleetNotFoundException();
        }

        $vehicle = $this->vehicleRepository->findByLicensePlate($licensePlate);
        $vehicleLocation = $vehicle->getLocation();
        if ($vehicleLocation && $vehicleLocation->equals(new Location($lat, $lng))) {
            throw new VehicleAlreadyParkedAtLocationException();
        }

        $location = new Location($lat, $lng);
        $location->setVehicle($vehicle);
        $vehicle->setLocation($location);

        $this->vehicleRepository->save($vehicle);
        $this->locationRepository->save($location);
        return $location;
    }

    public function reset(): void
    {
        $this->vehicleRepository->reset();
        $this->locationRepository->reset();
    }
}
