<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Event;

use Broadway\Serializer\Serializable;
use DDDStarterPack\Event\DomainEvent;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Aggregate\UserId;

abstract class UserEvent implements Serializable, DomainEvent
{
    public function __construct(
        public readonly UserId $userId,
        protected DateTimeRFC $occurredAt,
    ) {
    }

    protected function basicSerialize(): array
    {
        return [
            'user_id' => (string) $this->userId,
            'occurred_at' => (string) $this->occurredAt,
        ];
    }

    public function occurredAt(): DateTimeRFC
    {
        return $this->occurredAt;
    }

    protected static function createOccurredAt(string $occuredAt): DateTimeRFC
    {
        return DateTimeRFC::createFrom($occuredAt);
    }
}
