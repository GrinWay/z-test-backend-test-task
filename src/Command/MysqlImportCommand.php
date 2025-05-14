<?php

namespace App\Command;

use App\Service\MySqlService;
use GrinWay\Service\Service\StringService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:mysql:import',
)]
class MysqlImportCommand extends Command
{
    public function __construct(
        private readonly MySqlService $mySqlService,

        #[Autowire(env: 'resolve:APP_DB_IMPORT_FROM')]
        private readonly string $importFrom,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->mySqlService->import($this->importFrom);
        $io->success('MySql imported.');

        return Command::SUCCESS;
    }
}
