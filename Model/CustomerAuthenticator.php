<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Customer\Model\Customer;

/**
 * Class CustomerAuthenticator
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class CustomerAuthenticator
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * @var \MagedIn\LoginAsCustomer\Service\AdminUserService
     */
    private $adminUserService;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \MagedIn\LoginAsCustomer\Service\AdminUserService $adminUserService
    ) {
        $this->session = $session;
        $this->adminUserService = $adminUserService;
    }

    /**
     * @param int $customerId
     *
     * @return Customer|null
     */
    public function authenticate(int $customerId, int $adminUserId) : ?Customer
    {
        if ($this->session->isLoggedIn()) {
            $this->session->logout();
        }

        if (!$this->session->loginById($customerId)) {
            /** @todo Do something when authentication fails. */
            return null;
        }

        $this->session->regenerateId();
        $this->adminUserService->registerAdminUser($adminUserId);

        $customer = $this->session->getCustomer();
        return $customer;
    }
}
