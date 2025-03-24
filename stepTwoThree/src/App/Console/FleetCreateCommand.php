<?php

declare(strict_types=1);

namespace App\App\Console;

use App\App\Command\CreateFleetCommand;
use App\App\Handler\CreateFleetHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fleet:create',
    description: 'Creates a fleet',
)]
class FleetCreateCommand extends Command
{
    public function __construct(private readonly CreateFleetHandler $handler)
    {
        parent::__construct();
    }

    protected function configure() : void
    {
        $this
            ->setName('fleet:create')
            ->setDescription('Creates a fleet')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var string $fleetId */
        $fleetId = $input->getArgument('fleetId');

        $io->note(sprintf('Creating fleet with ID "%s"', $fleetId));

        try {
            $command = new CreateFleetCommand($fleetId);
            $this->handler->handle($command);

            $io->success('Your new fleet has been created!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
