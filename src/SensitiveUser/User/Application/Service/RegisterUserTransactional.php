<?php

declare(strict_types=1);

namespace SensitiveUser\User\Application\Service;

use DDDStarterPack\Exception\Application\TransactionFailedException;
use DDDStarterPack\Service\Application\TransactionalApplicationService;
use DDDStarterPack\Service\Application\TransactionalSession;
use SensitiveUser\User\Domain\Service\RegisterUserI;

class RegisterUserTransactional extends TransactionalApplicationService implements RegisterUserI
{
    public function __construct(RegisterUserI $service, TransactionalSession $session)
    {
        parent::__construct($service, $session);
    }

    /**
     * {@inheritDoc}
     *
     * @throws TransactionFailedException
     */
    public function execute($command): void
    {
        $this->executeInTransaction($command);
    }
}
