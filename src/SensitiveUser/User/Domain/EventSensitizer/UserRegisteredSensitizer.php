<?php

declare(strict_types=1);

namespace SensitiveUser\User\Domain\EventSensitizer;

use Assert\Assertion as Assert;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Matiux\Broadway\SensitiveSerializer\Serializer\Strategy\PayloadSensitizer;
use SensitiveUser\User\Domain\Event\UserRegistered;

/**
 * @psalm-suppress PossiblyInvalidCast
 */
class UserRegisteredSensitizer extends PayloadSensitizer
{
    /**
     * @throws AssertionFailedException
     */
    protected function generateSensitizedPayload(): array
    {
        $this->validatePayload($this->getPayload());

        $payload = $this->getPayload();
        $payload['email'] = $this->encryptValue((string) $this->getPayload()['email']);

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

//        if ($subject instanceof Serializable) {
//            return UserRegistered::class == $subject->serialize()['class'];
//        }

        throw new \InvalidArgumentException();
    }

    /**
     * @throws AssertionFailedException
     */
    protected function generateDesensitizedPayload(): array
    {
        $this->validatePayload($this->getPayload());

        $payload = $this->getPayload();
        $payload['email'] = $this->decryptValue((string) $this->getPayload()['email']);

        return $payload;
    }

    /**
     * @throws AssertionFailedException
     */
    protected function validatePayload(array $payload): void
    {
        Assert::keyExists($payload, 'email', "Key 'email' should be set in payload.");
    }
}
