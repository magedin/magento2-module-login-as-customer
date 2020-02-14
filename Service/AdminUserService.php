<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Service;

use Magento\Customer\Model\Session;
use Magento\User\Api\Data\UserInterface;

/**
 * Class AdminUserService
 *
 * @package MagedIn\LoginAsCustomer\Service
 */
class AdminUserService
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    private $userFactory;

    /**
     * @var \Magento\User\Model\ResourceModel\User
     */
    private $userResource;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\User\Model\ResourceModel\User $userResource
    ) {
        $this->session = $session;
        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
    }

    /**
     * @return UserInterface
     */
    public function getRegisteredAdminUser() : UserInterface
    {
        if ($this->user && $this->user->getId()) {
            return $this->user;
        }

        $this->user = $this->userFactory->create();

        if ($this->getAdminUserId()) {
            $this->userResource->load($this->user, $this->getAdminUserId());
        }

        return $this->user;
    }

    /**
     * @param int $adminUserId
     *
     * @return $this
     */
    public function registerAdminUser(int $adminUserId) : self
    {
        $this->session->setLoggedAsCustomerAdminUserId($adminUserId);
        return $this;
    }

    /**
     * @return int
     */
    private function getAdminUserId()
    {
        $adminUserId = (int) $this->session->getLoggedAsCustomerAdminUserId();
        return $adminUserId;
    }
}
