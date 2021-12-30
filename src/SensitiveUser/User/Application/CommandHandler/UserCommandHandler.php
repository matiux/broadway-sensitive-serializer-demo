<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\CommandHandler;

use Broadway\CommandHandling\SimpleCommandHandler;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Application\Command\RegisterUserCommand;
use SensitiveUser\User\Domain\Aggregate\User;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Aggregate\Users;

class UserCommandHandler extends SimpleCommandHandler
{
    public function __construct(
        private Users $users
    ) {
    }

    public function handleRegisterUserCommand(RegisterUserCommand $command): void
    {
        $user = User::create(
            UserId::createFrom($command->userId),
            $command->name,
            $command->surname,
            $command->email,
            DateTimeRFC::createFrom($command->registrationDate)
        );

        $this->users->add($user);
    }
}
