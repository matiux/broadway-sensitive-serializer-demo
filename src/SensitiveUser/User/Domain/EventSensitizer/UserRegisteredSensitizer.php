<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\EventSensitizer;

use Assert\Assertion as Assert;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Matiux\Broadway\SensitiveSerializer\Serializer\Strategy\PayloadSensitizer;
use SensitiveUser\User\Domain\Event\UserRegistered;

class UserRegisteredSensitizer extends PayloadSensitizer
{
    /**
     * {@inheritDoc}
     *
     * @throws AssertionFailedException
     */
    protected function generateSensitizedPayload(string $decryptedAggregateKey): array
    {
        $this->validatePayload($this->getPayload());

        $email = $this->getSensitiveDataManager()->encrypt(
            sensitiveData: (string) $this->getPayload()['email'],
            secretKey: $decryptedAggregateKey
        );

        $payload = $this->getPayload();
        $payload['email'] = $email;

        return $payload;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($subject): bool
    {
        if (is_array($subject)) {
            return UserRegistered::class == $subject['class'];
        }

        if ($subject instanceof Serializable) {
            return UserRegistered::class == $subject->serialize()['class'];
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @throws AssertionFailedException
     */
    protected function generateDesensitizedPayload(string $decryptedAggregateKey): array
    {
        $this->validatePayload($this->getPayload());

        $email = $this->getSensitiveDataManager()->decrypt(
            encryptedSensitiveData: (string) $this->getPayload()['email'],
            secretKey: $decryptedAggregateKey
        );

        $payload = $this->getPayload();
        $payload['email'] = $email;

        return $payload;
    }

    /**
     * @psalm-assert MyEvent $payload
     *
     * @throws AssertionFailedException
     */
    protected function validatePayload(array $payload): void
    {
        Assert::keyExists($payload, 'email', "Key 'email' should be set in payload.");
    }
}
