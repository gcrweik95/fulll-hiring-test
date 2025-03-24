<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
use App\Domain\Exception\VehicleNotFoundInFleetException;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Domain\Service\FleetService;
use App\Domain\Service\VehicleService;
use App\Domain\Model\Location;
use App\Domain\Service\Test\DatabaseEmptyService;
use Behat\Behat\Context\Context;
use Behat\Hook\BeforeScenario;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private ?Fleet $fleet = null;
    private ?Fleet $otherFleet = null;
    private ?Vehicle $vehicle = null;
    private ?Location $location = null;
    private ?\Exception $exception = null;


    public function __construct(
        private readonly FleetService $fleetService,
        private readonly VehicleService $vehicleService,
        private readonly DatabaseEmptyService $databaseEmptyService
    ) {}

    #[BeforeScenario]
    public function reset(): void
    {
        $this->databaseEmptyService->emptyDB();
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
            $this->vehicleService->registerVehicle($this->fleet->getFleetId(), $this->vehicle->getLicensePlate());
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
        Assert::assertInstanceOf(VehicleAlreadyRegisteredException::class, $this->exception);
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
        $this->vehicleService->registerVehicle($this->otherFleet->getFleetId(), $this->vehicle->getLicensePlate());
    }

    #[Given('a location')]
    public function aLocation(): void
    {
        $this->location = $this->vehicleService->parkVehicle($this->fleet->getFleetId(), $this->vehicle->getLicensePlate(), 43.2, 5.4);
    }

    #[When('I park my vehicle at this location')]
    #[Given('my vehicle has been parked into this location')]
    #[When('I try to park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->vehicleService->parkVehicle(
                $this->fleet->getFleetId(),
                $this->vehicle->getLicensePlate(),
                $this->location->getLat(),
                $this->location->getLng()
            );
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        $vehicleLocation = $this->vehicle->getLocation();
        Assert::assertTrue($this->location->equals($vehicleLocation->getLat(), $vehicleLocation->getLng()));
    }


    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        Assert::assertInstanceOf(VehicleAlreadyParkedAtLocationException::class, $this->exception);
        $this->exception = null;
    }
}
