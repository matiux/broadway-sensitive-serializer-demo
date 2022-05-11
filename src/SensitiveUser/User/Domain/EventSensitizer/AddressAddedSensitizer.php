<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\EventSensitizer;

use Assert\Assertion as Assert;
use Assert\AssertionFailedException;
use InvalidArgumentException;
use Matiux\Broadway\SensitiveSerializer\Serializer\Strategy\PayloadSensitizer;
use SensitiveUser\User\Domain\Event\AddressAdded;

class AddressAddedSensitizer extends PayloadSensitizer
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
            sensitiveData: (string) $this->getPayload()['address'],
            secretKey: $decryptedAggregateKey
        );

        $payload = $this->getPayload();
        $payload['address'] = $email;

        return $payload;
    }

    /**
     * @throws AssertionFailedException
     */
    protected function generateDesensitizedPayload(string $decryptedAggregateKey): array
    {
        $this->validatePayload($this->getPayload());

        $email = $this->getSensitiveDataManager()->decrypt(
            encryptedSensitiveData: (string) $this->getPayload()['address'],
            secretKey: $decryptedAggregateKey
        );

        $payload = $this->getPayload();
        $payload['address'] = $email;

        return $payload;
    }

    public function supports($subject): bool
    {
        if (is_array($subject)) {
            return AddressAdded::class == $subject['class'];
        }

        throw new InvalidArgumentException();
    }

    /**
     * @throws AssertionFailedException
     */
    protected function validatePayload(array $payload): void
    {
        Assert::keyExists($payload, 'address', "Key 'address' should be set in payload.");
    }
}
