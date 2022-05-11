<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\ReadModel\ListUser;

use SensitiveUser\User\Domain\Aggregate\UserId;

interface ListUsers
{
    public function add(ListUser $listUser): void;

    public function update(ListUser $listUser): void;

    public function byId(UserId $userId): null|ListUser;

    /**
     * @return list<ListUser>
     */
    public function all(): array;

    public function delete(ListUser $listUser): void;
}
