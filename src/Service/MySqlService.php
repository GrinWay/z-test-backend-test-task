<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Process\Process;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class MySqlService
{
    public function __construct(
        #[Autowire(env: 'resolve:APP_DATABASE_USER')]
        public readonly string $dbUser,

        #[Autowire(env: 'resolve:APP_DATABASE_NAME')]
        public readonly string $dbName,
    )
    {
    }

    public function import(string $path): void
    {
        Validation::createCallable(
            new Assert\File(),
        )($path);

        $process = new Process([
            'docker',
            'exec',
            'z_task_db',
            'mysqldump',
            '-u',
            $this->dbUser,
            '-p',
            $this->dbName,
        ]);
        $process->mustRun();

        \dump($process->getOutput());
    }
}
