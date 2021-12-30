<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\Aggregate;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use SensitiveUser\Shared\Domain\ValueObject\DateTimeRFC;
use SensitiveUser\User\Domain\Event\UserRegistered;

class User extends EventSourcedAggregateRoot
{
    private UserId $userId;
    private string $name;
    private string $surname;
    private string $email;

    public static function create(UserId $userId, string $name, string $surname, string $email, DateTimeRFC $registrationDate): self
    {
        $user = new self();
        $user->apply(new UserRegistered($userId, $name, $surname, $email, $registrationDate));

        return  $user;
    }

    protected function applyUserRegistered(UserRegistered $event): void
    {
        $this->userId = $event->userId;
        $this->name = $event->name;
        $this->surname = $event->surname;
        $this->email = $event->email;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->userId;
    }
}
