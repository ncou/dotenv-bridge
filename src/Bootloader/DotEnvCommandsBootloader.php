<?php

declare(strict_types=1);

namespace Chiron\DotEnv\Bootloader;

use Chiron\Console\Console;
use Chiron\Core\Container\Bootloader\AbstractBootloader;
use Chiron\DotEnv\Command\DotEnvCopyCommand;
use Chiron\DotEnv\Command\DotEnvKeyCommand;

final class DotEnvCommandsBootloader extends AbstractBootloader
{
    public function boot(Console $console): void
    {
        $console->addCommand(DotEnvCopyCommand::getDefaultName(), DotEnvCopyCommand::class);
        $console->addCommand(DotEnvKeyCommand::getDefaultName(), DotEnvKeyCommand::class);
    }
}
