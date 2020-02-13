<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

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

    public function __construct(
        \Magento\Customer\Model\Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @param int $customerId
     *
     * @return \Magento\Customer\Model\Customer|null
     */
    public function authenticate(int $customerId) : ?\Magento\Customer\Model\Customer
    {
        if ($this->session->isLoggedIn()) {
            $this->session->logout();
        }

        if (!$this->session->loginById($customerId)) {
            /** @todo Do something when authentication fails. */
            return null;
        }

        $customer = $this->session->getCustomer();
        return $customer;
    }
}
