<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ValueObject;

use Matiux\Broadway\SensitiveSerializer\DataManager\Domain\Service\SensitiveTool;
use SensitiveUser\User\Domain\Exception\InvalidUserException;

class Email
{
    /**
     * @throws InvalidUserException
     */
    private function __construct(private readonly string $email)
    {
        $this->ensureEmailIsValid();
    }

    /**
     * @param string $email
     *
     * @throws InvalidUserException
     *
     * @return self
     */
    public static function crea(string $email): self
    {
        return new self($email);
    }

    /**
     * @throws InvalidUserException
     */
    private function ensureEmailIsValid(): void
    {
        if (SensitiveTool::isSensitized($this->email)) {
            return;
        }

        if (false === filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidUserException::invalidEmail($this->email);
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
