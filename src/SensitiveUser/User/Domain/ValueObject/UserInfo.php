<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ValueObject;

use Webmozart\Assert\Assert;

class UserInfo
{
    private function __construct(
        public readonly int $age,
        public readonly float $height,
        public readonly array $characteristics,
    ) {
        Assert::notEmpty($this->characteristics, 'Provide at least one user characteristic');
    }

    /**
     * @param int          $age
     * @param float        $height
     * @param list<string> $characteristics
     *
     * @return self
     */
    public static function crea(int $age, float $height, array $characteristics): self
    {
        return new self($age, $height, $characteristics);
    }
}
