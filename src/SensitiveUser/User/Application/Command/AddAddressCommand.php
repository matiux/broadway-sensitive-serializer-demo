<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Command;

class AddAddressCommand
{
    public function __construct(
        public readonly string $userId,
        public readonly string $address,
        public readonly string $occurredAt,
    ) {
    }
}
