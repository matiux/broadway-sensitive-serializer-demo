<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Exception;

use DDDStarterPack\Exception\Domain\DomainException;
use SensitiveUser\User\Domain\Aggregate\UserId;
use Throwable;

class InvalidUserException extends DomainException
{
    public static function invalidEmail(string $email, Throwable $previous = null): self
    {
        return new self(sprintf('Invalid email [%s]', $email), 0, $previous);
    }

    public static function userNotFound(UserId $userId, Throwable $previous = null): self
    {
        return new self(sprintf('User not found [%s]', (string) $userId), 0, $previous);
    }
}
