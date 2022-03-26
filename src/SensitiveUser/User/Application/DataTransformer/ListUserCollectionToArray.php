<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\DataTransformer;

use DDDStarterPack\DataTransformer\Application\BasicCollectionDataTransformer;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUser;

/**
 * @extends BasicCollectionDataTransformer<ListUser, array>
 */
class ListUserCollectionToArray extends BasicCollectionDataTransformer
{
    public function read(): array
    {
        $listUsers = [];

        /** @var array<int, ListUser> $collection */
        $collection = $this->items;

        foreach ($collection as $listUser) {
            $listUsers[] = [
                'id' => $listUser->getId(),
                'email' => $listUser->email,
            ];
        }

        return $listUsers;
    }
}
