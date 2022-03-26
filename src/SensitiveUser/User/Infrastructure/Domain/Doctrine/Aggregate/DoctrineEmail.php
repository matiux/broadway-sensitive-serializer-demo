<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Domain\Doctrine\Aggregate;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use SensitiveUser\User\Domain\Exception\InvalidUserException;
use SensitiveUser\User\Domain\ValueObject\Email;

class DoctrineEmail extends StringType
{
    /**
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param Email            $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return (string) $value;
    }

    /**
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @throws InvalidUserException
     *
     * @return Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return Email::crea($value);
    }
}
