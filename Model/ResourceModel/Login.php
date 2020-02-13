<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use MagedIn\LoginAsCustomer\Api\Data;

/**
 * Class Login
 *
 * @package MagedIn\LoginAsCustomer\Model\ResourceModel
 */
class Login extends AbstractDb
{
    /**
     * @var string
     */
    const TABLE = 'magedin_login_as_customer_secret';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE, 'id');
    }

    /**
     * @param Data\LoginInterface $login
     * @param int                 $customerId
     *
     * @return Data\LoginInterface
     */
    public function loadByCustomerId(Data\LoginInterface $login, int $customerId)
    {
        $this->load($login, $customerId, Data\LoginInterface::CUSTOMER_ID);
        return $login;
    }

    /**
     * @param Data\LoginInterface $login
     * @param string              $secret
     *
     * @return Data\LoginInterface
     */
    public function loadBySecret(Data\LoginInterface $login, string $secret)
    {
        $this->load($login, $secret, Data\LoginInterface::SECRET);
        return $login;
    }

    /**
     * @param int $customerId
     *
     * @return bool
     */
    public function deleteByCustomerId(int $customerId) : bool
    {
        $condition = new \Zend\Db\Sql\Expression("customer_id = {$customerId}");
        $result = $this->getConnection()->delete(self::TABLE, $condition->getExpression());

        return (bool) $result;
    }
}
