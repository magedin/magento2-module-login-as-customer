<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use MagedIn\LoginAsCustomer\Api\SecretManagerInterface;

/**
 * Class SecretManager
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class SecretManager implements SecretManagerInterface
{
    /**
     * @var int
     */
    const HASH_LENGTH = 128;

    /**
     * @var \MagedIn\LoginAsCustomer\Api\HashGeneratorInterface
     */
    private $hashGenerator;

    public function __construct(
        \MagedIn\LoginAsCustomer\Api\HashGeneratorInterface $hashGenerator
    ) {
        $this->hashGenerator = $hashGenerator;
    }

    /**
     * @inheritDoc
     */
    public function generate() : string
    {
        return $this->hashGenerator->generateHash(self::HASH_LENGTH);
    }

    /**
     * @inheritDoc
     */
    public function match(int $customerId, string $secret) : bool
    {
        // TODO: Implement match() method.
    }
}
