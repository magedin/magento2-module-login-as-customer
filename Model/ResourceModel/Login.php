<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use MagedIn\LoginAsCustomer\Api\Data;

/**
 * Class Login
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
    public function loadByCustomerId(Data\LoginInterface $login, int $customerId) : Data\LoginInterface
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
    public function loadBySecret(Data\LoginInterface $login, string $secret) : Data\LoginInterface
    {
        $this->load($login, $secret, Data\LoginInterface::SECRET);
        return $login;
    }

    /**
     * @param int $customerId
     *
     * @return bool
     */
    public function deleteByCustomerId(int $customerId) : int
    {
        return $this->deleteByExpression(new \Zend\Db\Sql\Expression("customer_id = {$customerId}"));
    }

    /**
     * @param string $secret
     *
     * @return bool
     */
    public function deleteBySecret(string $secret) : int
    {
        return $this->deleteByExpression(new \Zend\Db\Sql\Expression("secret = {$secret}"));
    }

    /**
     * @param \Zend\Db\Sql\Expression $expression
     *
     * @return int
     */
    private function deleteByExpression(\Zend\Db\Sql\Expression $expression) : int
    {
        $result = $this->getConnection()->delete(self::TABLE, $expression->getExpression());
        return (int) $result;
    }
}
