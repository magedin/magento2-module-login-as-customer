<?php

declare(strict_types = 1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Customer\Model\Customer;

/**
 * Class LoginProcessorInterface
 *
 * @package MagedIn\LoginAsCustomer\Model
 */
interface LoginProcessorInterface
{
    /**
     * @param int $customerId
     * @param int $adminUserId
     *
     * @return Customer
     */
    public function process(int $customerId, int $adminUserId) : ?Customer;
}
