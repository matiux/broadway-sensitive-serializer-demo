<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Service;

use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Aggregate\User;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Aggregate\Users;
use SensitiveUser\User\Domain\ValueObject\Email;
use SensitiveUser\User\Domain\ValueObject\UserInfo;

class RegisterUser implements RegisterUserI
{
    public function __construct(
        private Users $users
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute($command): void
    {
        $user = User::create(
            UserId::createFrom($command->userId),
            $command->name,
            $command->surname,
            Email::crea($command->email),
            UserInfo::crea(
                $command->age,
                $command->height,
                $command->characteristics,
            ),
            DateTimeRFC::createFrom($command->registrationDate)
        );

        $this->users->add($user);
    }
}
