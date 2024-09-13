<?php

namespace Bundles\AcmeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CacheClearFmkCommand extends Command
{

    protected static $defaultName = 'eleves:cache-clear';
    protected static $defaultDescription = 'Delete twig cache';
    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $realCacheDir = __DIR__."/../../../../cache/" ;
        $fs = new Filesystem();
        $fs->remove($realCacheDir);
        $fs->mkdir($realCacheDir);
        $fs->chown($realCacheDir , 'www-data', true);
        $output->writeln("<info>Cache removed successfully</info>") ;
        return Command::SUCCESS;

    }
}