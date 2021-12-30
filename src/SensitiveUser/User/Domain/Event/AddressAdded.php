<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Event;

use SensitiveUser\Shared\Domain\Event\BasicEvent;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Aggregate\UserId;

/**
 * @extends BasicEvent<UserId>
 */
class AddressAdded extends BasicEvent
{
    public function __construct(
        UserId $userId,
        public readonly string $address,
        DateTimeRFC $occurredAt,
    ) {
        parent::__construct($userId, $occurredAt);
    }

    public static function deserialize(array $data): AddressAdded
    {
        return new self(
            UserId::createFrom((string) $data[self::AGGREGATE_ID_KEY]),
            (string) $data['address'],
            self::createOccurredAt((string) $data['occurred_at'])
        );
    }

    public function serialize(): array
    {
        $serialized = [
            'address' => $this->address,
        ];

        return $this->basicSerialize() + $serialized;
    }
}
