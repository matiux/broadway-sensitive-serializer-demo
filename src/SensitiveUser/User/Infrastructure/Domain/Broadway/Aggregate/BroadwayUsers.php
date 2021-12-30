<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Domain\Broadway\Aggregate;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use SensitiveUser\User\Domain\Aggregate\User;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Aggregate\Users;
use Webmozart\Assert\Assert;

class BroadwayUsers extends EventSourcingRepository implements Users
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new PublicConstructorAggregateFactory()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function byId(UserId $id): User
    {
        $user = parent::load((string) $id);

        Assert::isInstanceOf($user, User::class);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function add(User $user): void
    {
        parent::save($user);
    }

    /**
     * {@inheritDoc}
     */
    public function update(User $user): void
    {
        parent::save($user);
    }
}
