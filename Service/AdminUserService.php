<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Service;

use MagedIn\LoginAsCustomer\Model\Session;
use Magento\User\Api\Data\UserInterface;
use Magento\User\Model\ResourceModel\User;
use Magento\User\Model\UserFactory;
use Psr\Log\LoggerInterface;

class AdminUserService
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var User
     */
    private $userResource;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Session $session,
        UserFactory $userFactory,
        User $userResource,
        LoggerInterface $logger
    ) {
        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
        $this->session = $session;
        $this->logger = $logger;
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
        $this->initSession();
        $this->session->setLoggedAsCustomerAdminUserId($adminUserId);
        return $this;
    }

    /**
     * @return $this
     */
    public function unregisterAdminUser() : self
    {
        $this->initSession();
        $this->session->unsetLoggedAsCustomerAdminUserId();
        return $this;
    }

    /**
     * @return int
     */
    private function getAdminUserId()
    {
        $this->initSession();
        return (int) $this->session->getLoggedAsCustomerAdminUserId();
    }

    /**
     * @return $this
     */
    private function initSession() : self
    {
        try {
            $this->session->start();
        } catch (\Exception $e) {
            $this->logger->error($e);
        }

        return $this;
    }
}
