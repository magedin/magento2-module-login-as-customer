<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Framework\Session\Config\ConfigInterface;
use Magento\Framework\Session\SaveHandlerInterface;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\Session\SessionStartChecker;
use Magento\Framework\Session\SidResolverInterface;
use Magento\Framework\Session\StorageInterface;
use Magento\Framework\Session\ValidatorInterface;

/**
 * Class Session
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class Session extends SessionManager
{
    /**
     * @var string
     */
    const KEY = 'logged_as_customer_admin_user_id';

    /**
     * @param int $adminUserId
     *
     * @return $this
     */
    public function setLoggedAsCustomerAdminUserId(int $adminUserId) : self
    {
        $this->storage->setData(self::KEY, $adminUserId);
        return $this;
    }

    /**
     * @return $this
     */
    public function unsetLoggedAsCustomerAdminUserId() : self
    {
        $this->storage->unsetData(self::KEY, null);
        return $this;
    }

    /**
     * @return int
     */
    public function getLoggedAsCustomerAdminUserId() : int
    {
        return (int) $this->storage->getData(self::KEY);
    }
}
