<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Command;

class RegisterUserCommand
{
    /**
     * @param string       $userId
     * @param string       $name
     * @param string       $surname
     * @param string       $email
     * @param int          $age
     * @param float        $height
     * @param list<string> $characteristics
     * @param string       $registrationDate
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly int $age,
        public readonly float $height,
        public readonly array $characteristics,
        public readonly string $registrationDate,
    ) {
    }
}
