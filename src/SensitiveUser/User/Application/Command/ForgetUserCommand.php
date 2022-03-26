<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Command;

class ForgetUserCommand
{
    public function __construct(
        public readonly string $userId,
    ) {
    }
}
