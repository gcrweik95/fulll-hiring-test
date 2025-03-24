<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\Domain\Model\Fleet;
use Fulll\Domain\Service\FleetService;
use Fulll\Infra\Persistence\InMemoryFleetRepository;

class CreateFleetHandler
{
    private FleetService $fleetService;

    private InMemoryFleetRepository $fleetRepository;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->fleetService = new FleetService($this->fleetRepository);
    }
    public function handle(CreateFleetCommand $command): Fleet
    {
        $fleet = $this->fleetService->create($command->getFleetId());
        return $fleet;
    }
}
