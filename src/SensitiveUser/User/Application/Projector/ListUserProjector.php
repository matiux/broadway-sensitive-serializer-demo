<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Projector;

use Broadway\ReadModel\Projector;
use SensitiveUser\User\Domain\Event\UserRegistered;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUser;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUsers;

class ListUserProjector extends Projector
{
    public function __construct(
        private ListUsers $listUsers
    ) {
    }

    public function applyUserRegistered(UserRegistered $event): void
    {
        $listUser = ListUser::create(
            $event->aggregateId,
            $event->email
        );

        $this->listUsers->add($listUser);
    }
}
