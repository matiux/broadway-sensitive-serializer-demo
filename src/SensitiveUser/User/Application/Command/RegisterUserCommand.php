<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Command;

class RegisterUserCommand
{
    public function __construct(
        public readonly string $userId,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $registrationDate,
    ) {
    }
}
