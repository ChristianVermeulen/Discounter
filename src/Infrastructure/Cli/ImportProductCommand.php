<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Cli;

use Discounter\Application\Command\Product\Create;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ImportProductCommand extends Command
{
    protected static $defaultName = 'discounter:import:products';

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
        $json = file_get_contents($this->projectDir.'/import/products.json');
        $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $io = new SymfonyStyle($input, $output);
        $io->note(sprintf('Handling %d products', count($decoded)));

        foreach ($decoded as $product) {
            $io->note(sprintf('Importing product %s', $product['description']));

            $command = new Create(
                $product['id'],
                $product['description'],
                (int) $product['category'],
                $product['price']
            );
            $this->messageBus->dispatch($command);
        }

        $io->success('Done!');

        return 0;
    }
}
