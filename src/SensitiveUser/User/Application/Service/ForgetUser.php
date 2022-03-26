<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Service;

use DDDStarterPack\Service\Application\ApplicationService;
use Matiux\Broadway\SensitiveSerializer\DataManager\Domain\Aggregate\AggregateKeys;
use Matiux\Broadway\SensitiveSerializer\DataManager\Domain\Exception\AggregateKeyNotFoundException;
use Matiux\Broadway\SensitiveSerializer\DataManager\Domain\Service\AggregateKeyManager;
use Ramsey\Uuid\Rfc4122\UuidV4;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\Exception\InvalidUserException;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUser;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUsers;

/**
 * @implements ApplicationService<string, void>
 */
class ForgetUser implements ApplicationService
{
    public function __construct(
        private ListUsers $listUsers,
        private AggregateKeyManager $aggregateKeyManager,
        private AggregateKeys $aggregateKeys,
        private UserReplayer $userReplayer
    ) {
    }

    /**
     * @param string $userId
     *
     * @throws AggregateKeyNotFoundException
     * @throws InvalidUserException
     */
    public function execute($userId): void
    {
        $userId = UserId::createFrom($userId);

        $this->listUsers->delete($this->findListUserOrFail($userId));

        // TODO Improves id handling
        $aggregateKey = $this->aggregateKeyManager->obtainAggregateKeyOrFail(UuidV4::fromString((string) $userId));

        // TODO Include this algorithm in the AggregateKeyManager? Maybe in a forget() method
        if ($aggregateKey->exists()) {
            $aggregateKey->delete();
            $this->aggregateKeys->update($aggregateKey);
        }

        $this->userReplayer->replayForAggregate((string) $userId);
        // TODO End algorithm
    }

    /**
     * @param UserId $userId
     *
     * @throws InvalidUserException
     *
     * @return ListUser
     */
    private function findListUserOrFail(UserId $userId): ListUser
    {
        if (!$listUser = $this->listUsers->byId($userId)) {
            throw InvalidUserException::userNotFound($userId);
        }

        return $listUser;
    }
}
