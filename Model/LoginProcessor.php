<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Customer\Model\Customer;
use Magento\Framework\App\ResponseInterface;

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
     * @var CustomerAuthenticator
     */
    private $customerAuthenticator;

    public function __construct(
        \MagedIn\LoginAsCustomer\Model\CustomerAuthenticator $customerAuthenticator,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->eventManager = $eventManager;
        $this->messageManager = $messageManager;
        $this->customerAuthenticator = $customerAuthenticator;
    }

    /**
     * @inheritDoc
     */
    public function process(int $customerId, int $adminUserId) : ?Customer
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->customerAuthenticator->authenticate($customerId);

        if (!$customer->getId()) {
            $this->eventManager->dispatch('magedin_login_as_customer_fail', [
                'customer_id'   => $customerId,
                'admin_user_id' => $adminUserId
            ]);

            return null;
        }

        $this->eventManager->dispatch('magedin_login_as_customer_success', ['customer' => $customer]);

        return $customer;
    }
}
