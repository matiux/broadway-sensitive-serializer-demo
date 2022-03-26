<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Service;

use Broadway\Domain\DomainMessage;
use Broadway\EventStore\EventVisitor;
use Broadway\EventStore\Management\Criteria;
use Broadway\EventStore\Management\EventStoreManagement;
use SensitiveUser\User\Application\Projector\ListUserProjector;

// TODO include Replayer in broadway-sensitive-serializer
class UserReplayer implements EventVisitor
{
    // TODO Provide support for a collection of listeners
    public function __construct(
        private EventStoreManagement $eventStore,
        private ListUserProjector $eventListener
    ) {
    }

    public function doWithEvent(DomainMessage $domainMessage): void
    {
        $this->eventListener->handle($domainMessage);
    }

    public function replayForAggregate(string $aggregateId): void
    {
        $criteria = new Criteria();
        $criteria = $criteria->withAggregateRootIds([$aggregateId]);

        $this->eventStore->visitEvents($criteria, $this);
    }
}
