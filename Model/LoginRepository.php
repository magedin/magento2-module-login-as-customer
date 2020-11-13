<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use MagedIn\LoginAsCustomer\Api\Data;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Class LoginRepository
 *
 * This is the login repository class.
 */
class LoginRepository implements LoginRepositoryInterface
{
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
        return (bool) $this->resource->deleteBySecret($secret);
    }

    /**
     * @inheritDoc
     */
    public function deleteByCustomerId(int $customerId) : bool
    {
        return (bool) $this->resource->deleteByCustomerId($customerId);
    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function save(Data\LoginInterface $login) : Data\LoginInterface
    {
        $this->resource->save($login);
        return $login;
    }
}
