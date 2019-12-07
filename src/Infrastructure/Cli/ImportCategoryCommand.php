<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Cli;

use Discounter\Application\Command\Category\Create;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ImportCategoryCommand extends Command
{
    protected static $defaultName = 'discounter:import:category';

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

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $json = file_get_contents($this->projectDir.'/import/categories.json');
        $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $io = new SymfonyStyle($input, $output);
        $io->note(sprintf('Handling %d categories', count($decoded)));

        foreach ($decoded as $customer) {
            $io->note(sprintf('Importing category %s', $customer['name']));

            $command = new Create(
                (int) $customer['id'],
                $customer['name']
            );
            $this->messageBus->dispatch($command);
        }

        $io->success('Done!');

        return 0;
    }
}
