<?php

namespace App\Command;

use App\Service\MySqlService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:mysql:import_csv',
)]
class MysqlImportCommand extends Command
{
    public function __construct(
        private readonly MySqlService $mySqlService,

        #[Autowire(env: 'resolve:APP_DB_IMPORT_FROM')]
        private readonly string       $importFrom,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('table_name', InputArgument::REQUIRED, 'Table name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->mySqlService->importCSV(
            $this->importFrom,
            $input->getArgument('table_name'),
        );
        $io->success('MySql csv file imported.');

        return Command::SUCCESS;
    }
}
