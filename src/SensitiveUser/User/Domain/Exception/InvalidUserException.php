<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Exception;

use DDDStarterPack\Exception\Domain\DomainException;
use Throwable;

class InvalidUserException extends DomainException
{
    public static function invalidEmail(string $email, Throwable $previous = null): self
    {
        return new self(sprintf('Email non valida [%s]', $email), 0, $previous);
    }
}
