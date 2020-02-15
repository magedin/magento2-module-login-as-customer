<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Customer\Model\Customer;

/**
 * Class LoginProcessor
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
class LoginProcessor implements LoginProcessorInterface
{
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * @var AuthenticatorInterface
     */
    private $authenticator;

    public function __construct(
        \MagedIn\LoginAsCustomer\Model\AuthenticatorInterface $authenticator,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->eventManager = $eventManager;
        $this->messageManager = $messageManager;
        $this->authenticator = $authenticator;
    }

    /**
     * @inheritDoc
     */
    public function process(int $customerId, int $adminUserId) : ?Customer
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->authenticator->authenticate($customerId, $adminUserId);

        if (!$customer || !$customer->getId()) {
            $this->eventManager->dispatch('magedin_login_as_customer_fail', [
                'customer_id'   => $customerId,
                'admin_user_id' => $adminUserId
            ]);

            return null;
        }

        $this->eventManager->dispatch('magedin_login_as_customer_success', [
            'customer'      => $customer,
            'admin_user_id' => $adminUserId
        ]);

        return $customer;
    }
}
