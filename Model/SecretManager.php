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

    /**
     * @var \MagedIn\LoginAsCustomer\Api\LoginRepositoryInterface
     */
    private $loginRepository;

    /**
     * @var LoginFactory
     */
    private $loginFactory;

    /**
     * @var ResourceModel\Login
     */
    private $loginResource;

    public function __construct(
        \MagedIn\LoginAsCustomer\Api\HashGeneratorInterface $hashGenerator,
        \MagedIn\LoginAsCustomer\Api\LoginRepositoryInterface $loginRepository,
        \MagedIn\LoginAsCustomer\Model\LoginFactory $loginFactory,
        \MagedIn\LoginAsCustomer\Model\ResourceModel\Login $loginResource
    ) {
        $this->hashGenerator = $hashGenerator;
        $this->loginRepository = $loginRepository;
        $this->loginFactory = $loginFactory;
        $this->loginResource = $loginResource;
    }

    public function create(int $customerId, int $storeId, int $userId = null)
    {
        $this->loginResource->deleteByCustomerId($customerId);

        $login = $this->loginFactory->create();
        $login->setCustomerId($customerId);
        $login->setStoreId($storeId);
        $login->setAdminUserId($userId);
        $login->setSecret($this->generate());
        $login->setExpiresAt(date('Y-m-d H:i:s'));

        $this->loginRepository->save($login);

        return $login;
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
