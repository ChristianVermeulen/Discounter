<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Cli;

use Discounter\Application\Discounts\ApplyDiscounts;
use Discounter\Application\Discounts\Order\Order;
use Discounter\Application\Discounts\Order\OrderLine;
use Discounter\Domain\Customer\Id;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DiscountOrderCommand extends Command
{
    protected static $defaultName = 'discounter:discount';

    /**
     * @var ApplyDiscounts
     */
    private $discounts;

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @param ApplyDiscounts      $discounts
     * @param string              $projectDir
     */
    public function __construct(
        ApplyDiscounts $discounts,
        string $projectDir
    ) {
        $this->discounts = $discounts;
        $this->projectDir = $projectDir;
        parent::__construct();
    }

    public function configure()
    {
        $this->addArgument('order', InputArgument::OPTIONAL, 'Which order would you like to process?', 'order1');
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        $decoded = $this->getDecodedOrder($input->getArgument('order'));
        $order = Order::fromArray($decoded);

        $this->discounts->applyToOrder($order);

        $headers = ['product id', 'quanitity', 'price', 'totalprice'];
        $data = [];

        foreach($order->getOrderLines() as $orderLine) {
            $data[] = [
                $orderLine->getProductId(),
                $orderLine->getQuantity(),
                $moneyFormatter->format($orderLine->getUnitPrice()),
                $moneyFormatter->format($orderLine->getTotalPrice())
            ];
        }

        $data[] = ['Total', '', '', $moneyFormatter->format($order->getTotalPrice())];

        $io->table(
            $headers,
            $data
        );


        return 0;
    }

    /**
     * @param string $order $input
     *
     * @return mixed
     */
    private function getDecodedOrder(string $order): array
    {
        $json    = file_get_contents(
            sprintf(
                '%s%s%s%s',
                $this->projectDir,
                '/import/',
                $order,
                '.json'
            ));

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}
