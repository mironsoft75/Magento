<?php
namespace Icecube\Export\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Icecube\Export\Service\ExportService;

class CustomersExport extends Command
{
    protected $ExportService;

    public function __construct(
        ExportService $ExportService,
        string $name = null
    ) {
        $this->ExportService = $ExportService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('icecube:export:customers')
            ->setDescription('Export All Customers.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $result = $this->ExportService->CustomersExport();
            $output->writeln($result);
            return \Symfony\Component\Console\Command\Command::SUCCESS;
        } catch (\Exception $e) {
            // Handle exceptions
            $output->writeln($e->getMessage());
            return \Symfony\Component\Console\Command\Command::FAILURE;
        }
    }

}
