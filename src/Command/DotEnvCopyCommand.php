<?php

declare(strict_types=1);

namespace Chiron\DotEnv\Command;

use Chiron\Console\AbstractCommand;
use Chiron\Security\Config\SecurityConfig;
use Chiron\Filesystem\Filesystem;
use Chiron\Security\Security;
use Symfony\Component\Console\Input\InputOption;
use Chiron\Core\Environment;

final class DotEnvCopyCommand extends AbstractCommand
{
    protected static $defaultName = 'dotenv:copy';

    protected function configure()
    {
        $this
            ->setDescription('Copy the dotenv file.')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files');
    }

    protected function perform(Filesystem $filesystem, Directories $directories): int
    {
        $copied = $this->copyFile($filesystem, '../../resources/.env.sample', directory('@root/.env'));

        if ($copied) {
            $this->success('Dotenv file ".env" has been copied.');
        } else {
            $this->warning('Dotenv file ".env" was not copied!');
        }

        return self::SUCCESS;
    }

    /**
     * Copy the file to the given path.
     *
     * @param Filesystem $filesystem
     * @param string $from
     * @param string $to
     *
     * @param bool Return true if the copy is a success.
     */
    public function copyFile(Filesystem $filesystem, string $from, string $to): bool
    {
        if (! $filesystem->exists($to) || $this->option('force')) {
            return $filesystem->copy($from, $to);
        }

        return false;
    }
}