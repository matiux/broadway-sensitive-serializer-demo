<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Service;

use DDDStarterPack\Service\Domain\CommandService;
use SensitiveUser\User\Application\Command\RegisterUserCommand;
use SensitiveUser\User\Domain\Exception\InvalidUserException;

/**
 * @extends CommandService<RegisterUserCommand>
 */
interface RegisterUserI extends CommandService
{
    /**
     * @param RegisterUserCommand $command
     *
     * @throws InvalidUserException
     */
    public function execute($command): void;
}
