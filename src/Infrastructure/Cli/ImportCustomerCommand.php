<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Cli;

use Discounter\Application\Command\Customer\Import;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ImportCustomerCommand extends Command
{
    protected static $defaultName = 'discounter:import:customer';

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus, string $projectDir)
    {
        $this->projectDir = $projectDir;
        $this->messageBus = $messageBus;
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $json = file_get_contents($this->projectDir.'/import/customers.json');
        $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $io = new SymfonyStyle($input, $output);
        $io->note(sprintf('Handling %d customers', count($decoded)));

        foreach ($decoded as $customer) {
            $io->note(sprintf('Importing customer %s', $customer['name']));

            $command = new Import(
                (int) $customer['id'],
                $customer['name'],
                $customer['since'],
                $customer['revenue'],
            );
            $this->messageBus->dispatch($command);
        }

        $io->success('Done!');

        return 0;
    }
}
