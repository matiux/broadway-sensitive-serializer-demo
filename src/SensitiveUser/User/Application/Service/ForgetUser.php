<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Service;

use DDDStarterPack\Service\Application\ApplicationService;
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

        $this->aggregateKeyManager->forget(UuidV4::fromString((string) $userId));

        $this->userReplayer->replayForAggregate((string) $userId);
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
