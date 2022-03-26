<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Service;

use DDDStarterPack\Service\Application\NoRequestApplicationService;
use SensitiveUser\User\Application\DataTransformer\ListUserCollectionToArray;
use SensitiveUser\User\Domain\ReadModel\ListUser\ListUsers;

/**
 * @implements NoRequestApplicationService<array>
 */
class ShowUserList implements NoRequestApplicationService
{
    public function __construct(
        private ListUsers $listUsers,
        private ListUserCollectionToArray $dataTransformer,
    ) {
    }

    public function execute($request = null): array
    {
        return $this->dataTransformer->write($this->listUsers->all())->read();
    }
}
