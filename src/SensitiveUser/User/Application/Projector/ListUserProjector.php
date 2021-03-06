<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Projector;

use Broadway\ReadModel\Projector;
use InvalidArgumentException;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Event\AddressAdded;
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
            $event->name,
            $event->surname,
            $event->email,
            $event->userInfo->age,
            $event->userInfo->height,
            $event->userInfo->characteristics
        );

        $this->listUsers->add($listUser);
    }

    public function applyAddressAdded(AddressAdded $event): void
    {
        $listUser = $this->listUserOrFail($event->aggregateId);
        $listUser->editAddress($event->address);
        $this->listUsers->update($listUser);
    }

    private function listUserOrFail(UserId $userId): ListUser
    {
        if (!$listUser = $this->listUsers->byId($userId)) {
            throw new InvalidArgumentException(sprintf('User not found: %s', (string) $userId));
        }

        return $listUser;
    }
}
