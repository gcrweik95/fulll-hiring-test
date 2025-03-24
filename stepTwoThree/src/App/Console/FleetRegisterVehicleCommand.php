<?php

declare(strict_types=1);

namespace App\App\Console;

use App\App\Command\RegisterVehicleCommand;
use App\App\Handler\RegisterVehicleHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fleet:register-vehicle',
    description: 'Registers a vehicle in a fleet',
)]
class FleetRegisterVehicleCommand extends Command
{
    public function __construct(private readonly RegisterVehicleHandler $handler)
    {
        parent::__construct();
    }

    protected function configure() : void
    {
        $this
            ->setName('fleet:register-vehicle')
            ->setDescription('Registers a vehicle in a fleet')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet ID')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var string $fleetId */
        $fleetId = $input->getArgument('fleetId');
        /** @var string $vehiclePlateNumber */
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        $io->note(sprintf('Registering a vehicle with plate number "%s" in a fleet with an ID "%s"', $vehiclePlateNumber, $fleetId));

        try {
            $command = new RegisterVehicleCommand($fleetId, $vehiclePlateNumber);
            $this->handler->handle($command);

            $io->success('Your vehicle has been registered to the fleet!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
