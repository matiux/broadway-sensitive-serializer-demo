<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Domain\Doctrine\Aggregate;

use DDDStarterPack\Aggregate\Infrastructure\Doctrine\DoctrineEntityId;
use SensitiveUser\User\Domain\Aggregate\UserId;

class DoctrineUserId extends DoctrineEntityId
{
    public function getName(): string
    {
        return 'UserId';
    }

    protected function getFQCN(): string
    {
        return UserId::class;
    }
}
