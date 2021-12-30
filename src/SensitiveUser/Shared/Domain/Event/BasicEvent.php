<?php

declare(strict_types=1);

namespace SensitiveUser\Shared\Domain\Event;

use Broadway\Serializer\Serializable;
use DDDStarterPack\Aggregate\Domain\BasicEntityId;
use DDDStarterPack\Event\DomainEvent;
use JetBrains\PhpStorm\ArrayShape;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;

/**
 * @template I of BasicEntityId
 */
abstract class BasicEvent implements Serializable, DomainEvent
{
    public const AGGREGATE_ID_KEY = 'id';

    /**
     * @param I           $aggregateId
     * @param DateTimeRFC $occurredAt
     */
    public function __construct(
        public readonly mixed $aggregateId,
        protected DateTimeRFC $occurredAt,
    ) {
    }

    #[ArrayShape([self::AGGREGATE_ID_KEY => 'string', 'occurred_at' => 'string'])]
    protected function basicSerialize(): array
    {
        return [
            self::AGGREGATE_ID_KEY => (string) $this->aggregateId,
            'occurred_at' => (string) $this->occurredAt,
        ];
    }

    public function occurredAt(): DateTimeRFC
    {
        return $this->occurredAt;
    }

    protected static function createOccurredAt(string $occurredAt): DateTimeRFC
    {
        return DateTimeRFC::createFrom($occurredAt);
    }
}
