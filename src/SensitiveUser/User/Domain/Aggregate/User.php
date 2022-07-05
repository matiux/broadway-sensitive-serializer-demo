<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Aggregate;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Event\AddressAdded;
use SensitiveUser\User\Domain\Event\UserRegistered;
use SensitiveUser\User\Domain\ValueObject\Email;
use SensitiveUser\User\Domain\ValueObject\UserInfo;

class User extends EventSourcedAggregateRoot
{
    private UserId $userId;
    private string $name;
    private string $surname;
    private Email $email;
    private UserInfo $userInfo;
    private string $address;

    public static function create(
        UserId $userId,
        string $name,
        string $surname,
        Email $email,
        UserInfo $userInfo,
        DateTimeRFC $registrationDate,
    ): self {
        $user = new self();
        $user->apply(new UserRegistered($userId, $name, $surname, $email, $userInfo, $registrationDate));

        return $user;
    }

    protected function applyUserRegistered(UserRegistered $event): void
    {
        $this->userId = $event->aggregateId;
        $this->name = $event->name;
        $this->surname = $event->surname;
        $this->email = $event->email;
        $this->userInfo = $event->userInfo;
    }

    public function addAddress(string $address, DateTimeRFC $occurredAt): void
    {
        $this->apply(new AddressAdded($this->userId, $address, $occurredAt));
    }

    protected function applyAddressAdded(AddressAdded $event): void
    {
        $this->address = $event->address;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->userId;
    }
}
