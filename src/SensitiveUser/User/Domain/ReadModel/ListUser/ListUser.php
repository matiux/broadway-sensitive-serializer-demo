<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ReadModel\ListUser;

use Broadway\ReadModel\Identifiable;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\ValueObject\Email;
use Serializable;

class ListUser implements Identifiable, Serializable
{
    private null|string $address = null;

    private function __construct(
        private readonly UserId $userId,
        private readonly string $name,
        private readonly string $surname,
        public readonly Email $email,
        public readonly int $age,
        public readonly float $height,
        public readonly array $characteristics,
    ) {
    }

    public static function create(
        UserId $userId,
        string $name,
        string $surname,
        Email $email,
        int $age,
        float $height,
        array $characteristics
    ): self {
        return new self($userId, $name, $surname, $email, $age, $height, $characteristics);
    }

    public function editAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getId(): string
    {
        return (string) $this->userId;
    }

    public function serialize(): array
    {
        return [
            'id' => (string) $this->userId,
            'email' => (string) $this->email,
            'name' => $this->name,
            'surname' => $this->surname,
            'user_info' => [
                'age' => $this->age,
                'height' => $this->height,
                'characteristics' => $this->characteristics,
            ],
            'address' => $this->address,
        ];
    }

    public function unserialize(string $data)
    {
        throw new \BadMethodCallException();
    }

    public function __serialize(): array
    {
        return $this->serialize();
    }

    public function __unserialize(array $data): void
    {
        throw new \BadMethodCallException();
    }
}
