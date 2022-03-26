<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ReadModel\ListUser;

use Broadway\ReadModel\Identifiable;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\ValueObject\Email;

class ListUser implements Identifiable
{
    public function __construct(
        private readonly UserId $userId,
        public readonly Email $email
    ) {
    }

    public static function create(UserId $userId, Email $email): self
    {
        return new self($userId, $email);
    }

    public function getId(): string
    {
        return (string) $this->userId;
    }
}
