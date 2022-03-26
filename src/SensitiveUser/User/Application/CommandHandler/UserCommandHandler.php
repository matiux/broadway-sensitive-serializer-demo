<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\CommandHandler;

use Broadway\CommandHandling\SimpleCommandHandler;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Application\Command\AddAddressCommand;
use SensitiveUser\User\Application\Command\ForgetUserCommand;
use SensitiveUser\User\Application\Command\RegisterUserCommand;
use SensitiveUser\User\Application\Service\ForgetUser;
use SensitiveUser\User\Domain\Aggregate\User;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Aggregate\Users;
use SensitiveUser\User\Domain\Exception\InvalidUserException;
use SensitiveUser\User\Domain\ValueObject\Email;

class UserCommandHandler extends SimpleCommandHandler
{
    public function __construct(
        private Users $users,
        private ForgetUser $forgetUser
    ) {
    }

    /**
     * @param RegisterUserCommand $command
     *
     * @throws InvalidUserException
     */
    public function handleRegisterUserCommand(RegisterUserCommand $command): void
    {
        $user = User::create(
            UserId::createFrom($command->userId),
            $command->name,
            $command->surname,
            Email::crea($command->email),
            DateTimeRFC::createFrom($command->registrationDate)
        );

        $this->users->add($user);
    }

    public function handleAddAddressCommand(AddAddressCommand $command): void
    {
        $user = $this->users->byId(UserId::createFrom($command->userId));

        $user->addAddress($command->address, DateTimeRFC::createFrom($command->occurredAt));

        $this->users->update($user);
    }

    public function handleForgetUserCommand(ForgetUserCommand $command): void
    {
        $this->forgetUser->execute($command->userId);
    }
}
