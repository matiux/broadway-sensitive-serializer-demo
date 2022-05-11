<?php

declare(strict_types=1);

namespace SensitiveUser\User\Infrastructure\Domain\Doctrine\ReadModel;

use DDDStarterPack\Aggregate\Infrastructure\Doctrine\Repository\DoctrineRepository;
use SensitiveUser\User\Domain\Aggregate\UserId;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUser;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUsers;

class DoctrineListUsers extends DoctrineRepository implements ListUsers
{
    protected function getEntityAliasName(): string
    {
        return 'lu';
    }

    public function add(ListUser $listUser): void
    {
        $this->em->persist($listUser);
        $this->em->flush();
        $this->em->clear();
    }

    public function update(ListUser $listUser): void
    {
        $this->add($listUser);
    }

    public function byId(UserId $userId): null|ListUser
    {
        /** @var null|ListUser $listUser */
        $listUser = $this->em->find(
            $this->getEntityClassName(),
            $userId
        );

        return $listUser;
    }

    public function all(): array
    {
        /** @var list<ListUser> $listUsers */
        $listUsers = $this->em->getRepository($this->getEntityClassName())->findAll();

        return $listUsers;
    }

    public function delete(ListUser $listUser): void
    {
        $this->em->remove($listUser);
        $this->em->flush();
    }
}
