<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Projector;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Broadway\EventStore\EventVisitor;
use Broadway\EventStore\Management\Criteria;
use Broadway\EventStore\Management\EventStoreManagement;
use SensitiveUser\User\Domain\Aggregate\UserId;

class UserReplayer implements EventVisitor
{
    /**
     * @param EventStoreManagement $eventStore
     * @param EventListener[]      $eventListeners
     */
    public function __construct(
        private EventStoreManagement $eventStore,
        private iterable $eventListeners,
    ) {
    }

    public function doWithEvent(DomainMessage $domainMessage): void
    {
        foreach ($this->eventListeners as $eventListener) {
            $eventListener->handle($domainMessage);
        }
    }

    public function replayForUser(UserId $userId): void
    {
        $criteria = new Criteria();
        $criteria = $criteria->withAggregateRootIds([$userId->id()]);

        $this->eventStore->visitEvents($criteria, $this);
    }
}
