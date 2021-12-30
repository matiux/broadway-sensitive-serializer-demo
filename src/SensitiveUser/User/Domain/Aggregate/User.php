<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Aggregate;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Event\AddressAdded;
use SensitiveUser\User\Domain\Event\UserRegistered;

class User extends EventSourcedAggregateRoot
{
    private UserId $userId;
    private string $name;
    private string $surname;
    private string $email;
    private string $address;

    public static function create(UserId $userId, string $name, string $surname, string $email, DateTimeRFC $registrationDate): self
    {
        $user = new self();
        $user->apply(new UserRegistered($userId, $name, $surname, $email, $registrationDate));

        return $user;
    }

    protected function applyUserRegistered(UserRegistered $event): void
    {
        $this->userId = $event->aggregateId;
        $this->name = $event->name;
        $this->surname = $event->surname;
        $this->email = $event->email;
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
