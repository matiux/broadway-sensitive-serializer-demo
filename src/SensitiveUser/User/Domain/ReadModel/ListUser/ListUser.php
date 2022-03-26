<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ReadModel\ListUser;

use Broadway\ReadModel\Identifiable;
use SensitiveUser\User\Domain\Aggregate\UserId;

class ListUser implements Identifiable
{
    public function __construct(
        private UserId $userId,
        private string $email
    ) {
    }

    public static function create(UserId $userId, string $email): self
    {
        return new self($userId, $email);
    }

    public function getId(): string
    {
        return (string) $this->userId;
    }
}
