<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use MagedIn\LoginAsCustomer\Api\Data\LoginInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Login
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class Login extends AbstractModel implements LoginInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'login_as_customer';

    /**
     * @var string
     */
    protected $_eventObject = 'login';

    protected function _construct()
    {
        $this->_init(ResourceModel\Login::class);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId() : int
    {
        return (int) $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId(int $customerId) : LoginInterface
    {
        $this->setData(self::CUSTOMER_ID, (int) $customerId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStoreId() : int
    {
        return (int) $this->getData(self::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId(int $storeId) : LoginInterface
    {
        $this->setData(self::STORE_ID, (int) $storeId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAdminUserId() : int
    {
        return (int) $this->getData(self::ADMIN_USER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setAdminUserId(int $userId) : LoginInterface
    {
        $this->setData(self::ADMIN_USER_ID, (int) $userId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSecret() : string
    {
        return $this->getData(self::SECRET);
    }

    /**
     * @inheritDoc
     */
    public function setSecret(string $secret) : LoginInterface
    {
        $this->setData(self::SECRET, $secret);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExpiresAt() : string
    {
        return (string) $this->getData(self::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setExpiresAt(string $expiration) : LoginInterface
    {
        $this->setData(self::EXPIRES_AT, $expiration);
        return $this;
    }
}
