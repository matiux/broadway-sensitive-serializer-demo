<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ReadModel\ListUser;

use Broadway\ReadModel\Identifiable;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\ValueObject\Email;

class ListUser implements Identifiable
{
    private null|string $address = null;

    private function __construct(
        private readonly UserId $userId,
        public readonly Email $email,
        public readonly int $age,
        public readonly float $height,
        public readonly array $characteristics,
    ) {
    }

    public static function create(UserId $userId, Email $email, int $age, float $height, array $characteristics): self
    {
        return new self($userId, $email, $age, $height, $characteristics);
    }

    public function editAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getId(): string
    {
        return (string) $this->userId;
    }
}
