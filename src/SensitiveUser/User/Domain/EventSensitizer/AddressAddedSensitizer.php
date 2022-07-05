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
     * @throws AssertionFailedException
     */
    protected function generateSensitizedPayload(): array
    {
        $this->validatePayload($this->getPayload());

        $payload = $this->getPayload();
        $payload['address'] = $this->encryptValue((string) $this->getPayload()['address']);

        return $payload;
    }

    /**
     * @throws AssertionFailedException
     */
    protected function generateDesensitizedPayload(): array
    {
        $this->validatePayload($this->getPayload());

        $payload = $this->getPayload();
        $payload['address'] = $this->decryptValue((string) $this->getPayload()['address']);

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
