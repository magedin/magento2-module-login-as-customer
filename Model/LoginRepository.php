<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use MagedIn\LoginAsCustomer\Api\Data;

/**
 * Class LoginRepository
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class LoginRepository implements LoginRepositoryInterface
{
    /**
     * @var ResourceModel\LoginFactory
     */
    private $loginResourceFactory;

    /**
     * @var ResourceModel\Login
     */
    private $resource;

    /**
     * @var LoginFactory
     */
    private $loginFactory;

    public function __construct(
        \MagedIn\LoginAsCustomer\Model\ResourceModel\Login $resource,
        \MagedIn\LoginAsCustomer\Model\LoginFactory $loginFactory
    ) {
        $this->resource = $resource;
        $this->loginFactory = $loginFactory;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $customerId) : ?Data\LoginInterface
    {
        $login = $this->loginFactory->create();
        $this->resource->loadByCustomerId($login, $customerId);
        return $login;
    }

    /**
     * @inheritDoc
     */
    public function getBySecret(string $secret) : ?Data\LoginInterface
    {
        $login = $this->loginFactory->create();
        $this->resource->loadBySecret($login, $secret);
        return $login;
    }

    /**
     * @inheritDoc
     */
    public function deleteBySecret(string $secret) : bool
    {
        // TODO: Implement deleteBySecret() method.
    }

    /**
     * @inheritDoc
     */
    public function save(Data\LoginInterface $login) : Data\LoginInterface
    {
        $this->resource->save($login);
        return $login;
    }
}
