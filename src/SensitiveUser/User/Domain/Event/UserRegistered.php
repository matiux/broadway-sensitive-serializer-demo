<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Event;

use Psalm\Pure;
use SensitiveUser\Shared\Domain\Event\BasicEvent;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Exception\InvalidUserException;
use SensitiveUser\User\Domain\ValueObject\Email;

/**
 * @extends BasicEvent<UserId>
 */
class UserRegistered extends BasicEvent
{
    #[Pure]
    public function __construct(
        UserId $userId,
        public readonly string $name,
        public readonly string $surname,
        public readonly Email $email,
        DateTimeRFC $occurredAt,
    ) {
        parent::__construct($userId, $occurredAt);
    }

    public function serialize(): array
    {
        $serialized = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => (string) $this->email,
        ];

        return $this->basicSerialize() + $serialized;
    }

    /**
     * @param array $data
     *
     * @throws InvalidUserException
     *
     * @return UserRegistered
     */
    public static function deserialize(array $data): UserRegistered
    {
        return new self(
            UserId::createFrom((string) $data[self::AGGREGATE_ID_KEY]),
            (string) $data['name'],
            (string) $data['surname'],
            Email::crea((string) $data['email']),
            self::createOccurredAt((string) $data['occurred_at'])
        );
    }
}
