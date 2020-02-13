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

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $dateTime;

    public function __construct(
        \MagedIn\LoginAsCustomer\Api\HashGeneratorInterface $hashGenerator,
        \MagedIn\LoginAsCustomer\Api\LoginRepositoryInterface $loginRepository,
        \MagedIn\LoginAsCustomer\Model\LoginFactory $loginFactory,
        \MagedIn\LoginAsCustomer\Model\ResourceModel\Login $loginResource,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->hashGenerator = $hashGenerator;
        $this->loginRepository = $loginRepository;
        $this->loginFactory = $loginFactory;
        $this->loginResource = $loginResource;
        $this->dateTime = $dateTime;
    }

    public function create(int $customerId, int $storeId, int $userId = null)
    {
        $this->loginResource->deleteByCustomerId($customerId);

        $login = $this->loginFactory->create();
        $login->setCustomerId($customerId);
        $login->setStoreId($storeId);
        $login->setAdminUserId($userId);
        $login->setSecret($this->generate());
        $login->setExpiresAt($this->getExpirationTime(1));

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
    public function match(int $customerId, int $storeId, string $secret) : bool
    {
        $login = $this->loginFactory->create();
        $this->loginResource->loadBySecret($login, $secret);

        if (!$login->getId()) {
            return false;
        }

        if ($login->getCustomerId() !== $customerId) {
            return false;
        }

        if ($login->getStoreId() !== $storeId) {
            return false;
        }

        if (!$this->validateExpirationTime($login->getExpiresAt())) {
            return false;
        }

        return true;
    }

    /**
     * @param string $expirationTime
     *
     * @return bool
     */
    private function validateExpirationTime(string $expirationTime) : bool
    {
        $expiresAt = strtotime($expirationTime);
        $now = strtotime('now');
        $difference = $expiresAt - $now;

        if ($difference < 0) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    private function getExpirationTime(int $addMinutes = null) : string
    {
        $input  = strtotime("+{$addMinutes} minutes");
        $datetime = $this->dateTime->date('Y-m-d H:i:s', $input);
        return $datetime;
    }
}
