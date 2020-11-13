<?php
/**
 * Copyright © MagedIn. All rights reserved.
 * See COPYING.txt for license details.
 *
 * @author Tiago Sampaio <tiago.sampaio@magedin.com>
 */

declare(strict_types=1);

namespace MagedIn\LoginAsCustomer\Model;

use Magento\Customer\Model\Customer;

/**
 * Class LoginProcessorInterface
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
