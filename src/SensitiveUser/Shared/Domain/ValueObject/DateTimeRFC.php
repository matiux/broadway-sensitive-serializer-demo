<?php

declare(strict_types=1);

namespace SensitiveUser\Shared\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * @psalm-immutable
 */
class DateTimeRFC extends DateTimeImmutable
{
    public function __toString(): string
    {
        return $this->format(DateTimeInterface::RFC3339_EXTENDED);
    }

    public static function createFrom(string $dateTime): DateTimeRFC
    {
        if (!$date = static::createFromFormat(DateTimeInterface::RFC3339_EXTENDED, $dateTime)) {
            throw new InvalidArgumentException(sprintf('Data non valida: %s', $dateTime));
        }

        return $date;
    }
}
