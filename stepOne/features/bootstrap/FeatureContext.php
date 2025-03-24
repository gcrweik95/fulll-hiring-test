<?php

use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Model\Vehicle;
use Behat\Behat\Context\Context;
use Behat\Hook\BeforeScenario;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Fulll\Domain\Service\FleetService;
use Fulll\Domain\Service\VehicleService;
use Fulll\Domain\Exception\VehicleNotFoundInFleetException;
use Fulll\Domain\Model\Location;
use Fulll\Infra\Persistence\InMemoryFleetRepository;
use Fulll\Infra\Persistence\InMemoryLocationRepository;
use Fulll\Infra\Persistence\InMemoryVehicleRepository;


class FeatureContext implements Context
{
    private ?Fleet $fleet = null;
    private ?Fleet $otherFleet = null;
    private ?Vehicle $vehicle = null;
    private ?Location $location = null;
    private ?\Exception $exception = null;

    private InMemoryFleetRepository $fleetRepository;
    private InMemoryVehicleRepository $vehicleRepository;
    private InMemoryLocationRepository $locationRepository;

    private FleetService $fleetService;
    private VehicleService $vehicleService;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->vehicleRepository = new InMemoryVehicleRepository();
        $this->locationRepository = new InMemoryLocationRepository();

        $this->fleetService = new FleetService($this->fleetRepository);
        $this->vehicleService = new VehicleService($this->fleetRepository, $this->vehicleRepository, $this->locationRepository);
    }

    #[BeforeScenario]
    public function reset(): void
    {
        $this->fleetService->reset();
        $this->vehicleService->reset();
    }

    #[Given('my fleet')]
    public function myFleet(): void
    {
        $this->fleet = $this->fleetService->create("First Fleet");
    }

    #[Given('a vehicle')]
    public function aVehicle(): void
    {
        $this->vehicle = $this->vehicleService->create("ABC123");
    }

    #[When('I register this vehicle into my fleet')]
    #[When('I try to register this vehicle into my fleet')]
    #[Given('I have registered this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $this->vehicleService->registerVehicle($this->fleet->getId(), $this->vehicle->getLicensePlate());
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $vehicleExistsInFleet = $this->fleetService->fleetHasVehicle($this->fleet, $this->vehicle);
        if (!$vehicleExistsInFleet) {
            $this->exception = new VehicleNotFoundInFleetException();
        }
    }

    #[Then('I should be informed this this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        if (!($this->exception instanceof \Exception) || $this->exception->getMessage() !== "Vehicle already registered in this fleet.") {
            throw new \Exception($this->exception->getMessage());
        }
        $this->exception = null;
    }

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): void
    {
        $this->otherFleet = $this->fleetService->create("Second Fleet");
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        $this->vehicleService->registerVehicle($this->otherFleet->getId(), $this->vehicle->getLicensePlate());
    }

    #[Given('a location')]
    public function aLocation(): void
    {
        $this->location = $this->vehicleService->parkVehicle($this->fleet->getId(), $this->vehicle->getLicensePlate(), 43.2, 5.4);
    }

    #[When('I park my vehicle at this location')]
    #[Given('my vehicle has been parked into this location')]
    #[When('I try to park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->vehicleService->parkVehicle(
                $this->fleet->getId(),
                $this->vehicle->getLicensePlate(),
                $this->location->getLat(),
                $this->location->getLng()
            );
        } catch (Exception $e) {
            $this->exception = $e;
        }
    }

    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        assert($this->location->equals($this->vehicle->getLocation()));
    }


    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if (!($this->exception instanceof \Exception) || $this->exception->getMessage() !== "Vehicle already parked in this location.") {
            throw new \Exception($this->exception->getMessage());
        }
        $this->exception = null;
    }
}
