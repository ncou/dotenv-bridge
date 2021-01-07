<?php

declare(strict_types=1);

namespace Chiron\DotEnv\Command;

use Chiron\Core\Console\AbstractCommand;
use Chiron\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

final class DotEnvCopyCommand extends AbstractCommand
{
    protected static $defaultName = 'dotenv:copy';

    protected function configure()
    {
        $this
            ->setDescription('Copy the dotenv file.')
            ->addOption('destination', 'd', InputOption::VALUE_REQUIRED, 'Destination path for the .env file')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files');
    }

    protected function perform(Filesystem $filesystem): int
    {
        $filepath = $this->option('destination');

        $copied = $this->copyFile($filesystem, __DIR__ . '/../../resources/.env.sample', $filepath);

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
     * @param string     $from
     * @param string     $to
     *
     * @return bool Return true if the copy is a success.
     */
    public function copyFile(Filesystem $filesystem, string $from, string $to): bool
    {
        if (! $filesystem->exists($to) || $this->option('force')) {
            return $filesystem->copy($from, $to);
        }

        return false;
    }
}
