<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Event;

use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Aggregate\UserId;

class UserRegistered extends UserEvent
{
    public function __construct(
        UserId $userId,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        DateTimeRFC $occurredAt,
    ) {
        parent::__construct($userId, $occurredAt);
    }

    public function serialize(): array
    {
        $serialized = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
        ];

        return $this->basicSerialize() + $serialized;
    }

    public static function deserialize(array $data)
    {
        return new self(
            UserId::createFrom((string) $data['user_id']),
            (string) $data['name'],
            (string) $data['surname'],
            (string) $data['email'],
            self::createOccurredAt((string) $data['occurred_at'])
        );
    }
}
